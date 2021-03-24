<?php

namespace App\Controller\Back;

use App\Entity\Walk;
use App\Form\WalkType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WalkController extends AbstractController
{
    /**
     * @Route("/back/walk/create", name="back_walk_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $walk = new Walk;

        $form = $this->createForm(WalkType::class, $walk);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $walk->setCreatedAt(new \DateTime());

            $em->persist($walk);
            
            $em->flush();

            //$this->addFlash('success', 'Ajout effectué avec succès');
            
            return $this->redirectToRoute('back_walk_create');



        }
        
        return $this->render('back/walk/create.html.twig', [
            'walk' => $walk,
            'form' => $form->createView(),
        ]);
    }
}
