<?php

namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParticipantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param UserPasswordEncoderInterface $encoder
     * @return json
     * @Route("/api/users", name="api_users_create", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder): Response
    {
        $jsonContent = $request->getContent();
        $user = $serializer->deserialize($jsonContent, User::class, 'json');
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
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->json(
            ['message' => 'L\'utilisateur '. $user->getNickname() .' a bien été crée.'],
            Response::HTTP_CREATED
        );
    }
}