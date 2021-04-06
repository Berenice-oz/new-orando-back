<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Walk;
use App\Repository\ParticipantRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;




class UserController extends AbstractController
{
    /**
     * Data of a user
     * @Route("/api/users/{id<\d+>}", name="api_users_read_item", methods={"GET"})
     */
    public function readItem(User $user = null, Walk $walk, ParticipantRepository $participantRepository, SerializerInterface $serializer, NormalizerInterface $normalizer):Response
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
        
        $result = $serializer->serialize($datas,'json',[AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true]);

        return $this->json(
            $result,
            Response::HTTP_OK,
            [],
            ['groups' => [
                'api_users_read_item',
                'api_walks_read_item'
            ]
            ]);
    }
}
