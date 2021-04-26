<?php

namespace App\Controller\Back;

use App\Repository\TagRepository;
use App\Repository\UserRepository;
use App\Repository\WalkRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * Back-Office home page
     * 
     * @param WalkRepository $walkRepository
     * @param UserRepository $userRepository
     * @param TagRepository $tagRepository
     * @return Response
     * 
     * Find last walks, users and tags
     * 
     * Passing these datas and render the template into the Response
     *
     * @Route("/back", name="home", methods={"GET"})
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