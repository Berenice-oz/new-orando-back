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
     * API endpoint for reading a single user's datas
     * 
     * @param User $user
     * @param ParticipantRepository $participantRepository
     * @return JSON
     * @link https://symfony.com/doc/current/components/serializer.html#normalizers
     * 
     * Get the user from params.
     * 
     * If it exist, find incoming and archived walks with participant repository.
     * 
     * Send user's and user's walk datas in JSON Response by using the normalizer who read the content of the class by calling the “getters” 
     * 
     * @Route("/api/users/{id<\d+>}", name="api_users_read_item", methods={"GET"})
     */
    public function readItem(User $user = null, ParticipantRepository $participantRepository): Response
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
            [
                'groups' => [
                    'api_users_read_item',
                ],
                ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                    return $object;
                }
            ]
        );
    }

    /**
     * API endpoint for creating a new user
     * 
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param UserPasswordEncoderInterface $encoder
     * @param SluggerInterface $slugger
     * @return json
     * @link https://symfony.com/doc/current/controller/upload_file.html
     * @link https://symfony.com/doc/current/controller.html#the-request-and-response-object
     *
     * Get datas from multiple/formdata
     *
     * Transform datas in Json, deserialize datas into User
     * 
     * If there aren't errors, endcode Password, save Picture file and filename (after sluggify to safely include file name as part of URL)
     *
     * Then persist and save the user
     * 
     * @Route("/api/users", name="api_users_create", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder, SluggerInterface $slugger): Response
    {
        $data = $request->request->all();
        $data = $serializer->serialize($data, 'json');
        $user = $serializer->deserialize($data, User::class, 'json');
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorsList = [];
            foreach ($errors as $error) {
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
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();
            try {
                $pictureFile->move(
                    $this->getParameter('profil_picture_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                $message = [
                    'error' => 'Un problème est survenu lors de l\'enregistrement de l\'image',
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                ];

                return $this->json($message, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $user->setPicture($newFilename);
        }
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->json(
            ['message' => 'L\'utilisateur ' . $user->getNickname() . ' a bien été crée.'],
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
            foreach ($errors as $error) {
                $label = $error->getPropertyPath();
                $message = $error->getMessage();
                $errorsList[$label] =  $message;
            }

            return $this->json(['errors' => $errorsList], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        //todo encoder le mdp si il est renseigné et non null
        $entityManager->flush();
        return $this->json(
            ['message' => 'Les informations de l\'utilisateur ' . $user->getNickname() . ' ont bien été modifiées.'],
            Response::HTTP_OK
        );
    }

    /**
     * API endpoint for contacting a user by sending a message by mail
     *
     * @param Request $request
     * @param MailerInterface $mailer
     * @param mixed $walk
     * @param UserRepository $userRepository
     * @return JSON
     * @link https://symfony.com/doc/current/mailer.html
     *
     * Transform JsonContent into array
     *
     * Get the message and the user(expeditor)
     * 
     * Find the expeditor with UserRepository
     * 
     * If the message exist or isnt empty send mail with MailerBundle
     *
     * @Route("/api/contact-user/{id<\d+>}", name="api_contact_user", methods={"POST"})
     */
    public function userContact(Request $request, MailerInterface $mailer, User $user = null, UserRepository $userRepository): Response
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
        if (!$userMessage || $userMessage = "") {
            $message = [
                'error' => 'Le message ne doit pas être vide.',
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ];

            return $this->json($message, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $userMessage = $jsonContent['message'];
        $recipientUserEmail =  $user->getEmail();
        $expeditor = $userRepository->find($jsonContent['user']);
        $email = (new TemplatedEmail());
        $email->getHeaders()->addTextHeader('X-Auto-Response-Suppress', 'OOF, DR, RN, NRN, AutoReply');
        $email->from(new Address('contact@orando.me'))
            ->to($recipientUserEmail)
            ->subject('O\'Rando - Vous avez reçu un nouveau message de ' . $expeditor->getNickname() . '!')
            ->htmlTemplate('email/email-contact_user.html.twig')
            ->text('Bonjour ' . $user->getNickname() . '

            Vous avez reçu un nouveau message de ' . $expeditor->getNickname() . ' sur Orando.me :
            
            ' . $userMessage . '
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
