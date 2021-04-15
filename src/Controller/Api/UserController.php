<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParticipantRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * API endpoint to read a single user's datas
     * 
     * @param User $user
     * @param ParticipantRepository $participantRepository
     * @return JSON
     * @link https://symfony.com/doc/current/components/serializer.html#normalizers
     * 
     * Get the user from params.
     * 
     * If exist, find incoming and archived walks with participant repository.
     * 
     * Send user's and user's walk datas in JSON Response by using the normalizer who read the content of the class by calling the “getters” 
     * 
     * @Route("/api/users/{id<\d+>}", name="api_users_read_item", methods={"GET"})
     */
    public function readItem(User $user = null, ParticipantRepository $participantRepository):Response
    {
        if ($user === null) {
            $message = [
                'error' => 'User not found.',
                'status' => Response::HTTP_NOT_FOUND,
            ];

            return $this->json($message, Response::HTTP_NOT_FOUND);
        }
        $incomingWalks = $participantRepository->findIncomingWalksByUser($user);
        $archivedWalks = $participantRepository->findArchivedWalksByUser($user);
        $datas = [
            'user' => $user,
            'incomingWalks' => $incomingWalks,
            'archivedWalks' => $archivedWalks,
        ];
        return $this->json(
            $datas,
            Response::HTTP_OK,
            [],
            ['groups' => [
                'api_users_read_item',
            ],
            ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function($object){
                return $object;
            }    
        ]);
    }

    /**
     * API endpoint to create a new user
     * 
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param UserPasswordEncoderInterface $encoder
     * @return json
     * 
     * @Route("/api/users", name="api_users_create", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder, SluggerInterface $slugger): Response
    {
        $data = $request->request->all();
        $data = $serializer->serialize($data,'json');
        $user = $serializer->deserialize($data, User::class, 'json');
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorsList = [];
            foreach ($errors as $error){
                $label = $error->getPropertyPath();
                $message = $error->getMessage();
                $errorsList[$label] =  $message;
            }
            
            return $this->json(['errors' => $errorsList], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
        $pictureFile = $request->files->get('picture');
        if ($pictureFile) {
            $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$pictureFile->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $pictureFile->move(
                    $this->getParameter('profil_picture_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents
            $user->setPicture($newFilename);
        }
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->json(
            ['message' => 'L\'utilisateur '. $user->getNickname() .' a bien été crée.'],
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/api/users/{id<\d+>}", name="api_users_update", methods={"PATCH"})
     */
    public function update(Request $request, SerializerInterface $serializer, User $user = null, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        if ($user === null) {
            $message = [
                'error' => 'User not found.',
                'status' => Response::HTTP_NOT_FOUND,
            ];

            return $this->json($message, Response::HTTP_NOT_FOUND);
        }
        $jsonContent = $request->getContent();
        $serializer->deserialize($jsonContent, User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorsList = [];
            foreach ($errors as $error){
                $label = $error->getPropertyPath();
                $message = $error->getMessage();
                $errorsList[$label] =  $message;
            }
            
            return $this->json(['errors' => $errorsList], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        //todo encoder le mdp si il est renseigné et non null
        $entityManager->flush();
        return $this->json(
            ['message' => 'Les informations de l\'utilisateur '. $user->getNickname() .' ont bien été modifiées.'],
            Response::HTTP_OK
        );
    }

    /**
     * API endpoint to contact a user by sending a message by mail
     * @Route("/api/contact-user/{id<\d+>}", name="api_contact_user", methods={"POST"})
     */
    public function userContact(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator, MailerInterface $mailer, User $user = null, UserRepository $userRepository): Response
    {
        if ($user === null) {
            $message = [
                'error' => 'User not found.',
                'status' => Response::HTTP_NOT_FOUND,
            ];

            return $this->json($message, Response::HTTP_NOT_FOUND);
        }
        $jsonContent = $request->toArray();
        $userMessage = $jsonContent['message'];
        if (!$userMessage || $userMessage = ""){
            $message = [
                'error' => 'Le message ne doit pas être vide.',
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ];

            return $this->json($message, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $userMessage = $jsonContent['message'];
        //Sinon on envoie le mail
        //User's email
        $recipientUserEmail =  $user->getEmail();
        //Expeditor
        $expeditor = $userRepository->find($jsonContent['user']);
        //Send mail
        $email = (new TemplatedEmail());
        $email->getHeaders()->addTextHeader('X-Auto-Response-Suppress', 'OOF, DR, RN, NRN, AutoReply');
        $email->from(new Address('contact@orando.me'))
            ->to($recipientUserEmail)
            ->subject('O\'Rando - Vous avez reçu un nouveau message de ' . $expeditor->getNickname() . '!')
            ->htmlTemplate('email/email-contact_user.html.twig')
            ->text('Bonjour '.$user->getNickname().'

            Vous avez reçu un nouveau message de '.$expeditor->getNickname().' sur Orando.me :
            
            '.$userMessage.'
            ')
            ->context([
                'message' => $userMessage,
                'user' => $user,
                'expeditor' => $expeditor
            ]);
        $mailer->send($email);

        return $this->json(
            ['message' => 'Le message a bien été envoyé'],
            Response::HTTP_OK
        );

    }
}