<?php

namespace App\Controller\Back;

use App\Entity\Walk;
use App\Form\WalkType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WalkController extends AbstractController
{
    /**
     * @Route("/back/walk/create", name="back_walk_create", methods={"GET", "POST"})
     */
    public function create(): Response
    {
        $walk = new Walk;

        $form = $this->createForm(WalkType::class, $walk);
        
        return $this->render('back/walk/create.html.twig', [
            'walk' => $walk,
            'form' => $form->createView(),
        ]);
    }
}
