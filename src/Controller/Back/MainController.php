<?php

namespace App\Controller\Back;

use App\Repository\TagRepository;
use App\Repository\UserRepository;
use App\Repository\WalkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * Back-Office home page
     *
     * @Route("/back", name="home", methods={"GET"})
     * 
     * @return Response
     */
    public function home(WalkRepository $walkRepository, UserRepository $userRepository, TagRepository $tagRepository)
    {
        $walks = $walkRepository->findLast();
        $users = $userRepository->findLast();
        $tags = $tagRepository->findLast();
        return $this->render('back/home.html.twig', [
            'walks' => $walks,
            'users' => $users,
            'tags' => $tags
        ]);
    }
}