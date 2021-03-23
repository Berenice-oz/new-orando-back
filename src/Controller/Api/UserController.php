<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * Data of a user
     * @Route("/api/users/{id<\d+>}", name="api_users_read_item", methods={"GET"})
     */
    public function readItem(User $user):Response
    {
        return $this->json(
            $user,
            Response::HTTP_OK,
            [],
            ['groups' => 'api_users_read_item'],
        );
    }
}
