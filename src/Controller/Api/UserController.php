<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\ParticipantRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * Data of a user
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
            ['groups' => 'api_users_read_item'],
        );
    }
}
