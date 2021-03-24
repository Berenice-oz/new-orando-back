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
     * This method display walk form(methods = GET) and treat data of the form (methods="POST")
     * 
     * @Route("/back/walk/create", name="back_walk_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        // we create a new Walk
        $walk = new Walk;

        // creation's form while giving the entity
        $form = $this->createForm(WalkType::class, $walk);

        // ask to the form to examine the request object
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //we ask the Manager to prepare itself to add our object in our database
            $em->persist($walk);
            
            // we ask to the Manager to save our object in our database
            $em->flush();
            
            // redirection
            return $this->redirectToRoute('back_walk_create');



        }
        
        return $this->render('back/walk/create.html.twig', [
            'walk' => $walk,
            //we send to the template "a view of the form" thank to createView()
            'form' => $form->createView(),
        ]);
    }
}
