<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Walk;
use App\Form\WalkType;
use App\Entity\Participant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class WalkController extends AbstractController
{
    /**
     * This method display walk form(methods = GET) and treat data of the form (methods="POST")
     * 
     * @Route("/walk/create", name="walk_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $em, SessionInterface $session): Response
    {
        // we create a new Walk
        $walk = new Walk;

        // creation's form while giving the entity
        $form = $this->createForm(WalkType::class, $walk);

         // Current user
         $user = $this->getUser();
      
        // ask to the form to examine the request object
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //Add current user as walk's creator
            $walk->setCreator($user);

            //we ask the Manager to prepare itself to add our object in our database
            $em->persist($walk);

            //Add current user as walk's participant
            $participant = new Participant();
            $participant->setUser($user);
            $participant->setWalk($walk);
            $em->persist($participant);
            
            
            // we ask to the Manager to save our object in our database
            $em->flush();

            $id = $walk->getId();
            
            // add a flash message to inform the user if his action is alright
            $this->addFlash('success', 'Votre randonnée a bien été crée <a href=\'http://localhost:8080/walk/'. $id .'\'> -> Consulter votre randonnée</a>.');
            
            // redirection
            return $this->redirectToRoute('walk_create');

        }
        
        return $this->render('walk/create.html.twig', [
            'walk' => $walk,
            //we send to the template "a view of the form" thank to createView()
            'form' => $form->createView(),
        ]);
    }
 
    /**
     * Edit a walk
     * 
     * @Route("/walk/edit/{id<\d+>}", name="walk_edit", methods={"GET","POST"})
     *
     */
    public function edit(Walk $walk = null, Request $request, EntityManagerInterface $em, SessionInterface $session)
    {
        // managing error => 404 
        if (null === $walk) {
            
            throw $this->createNotFoundException('Randonnée non trouvée.');
        }
        $this->denyAccessUnlessGranted('edit', $walk);
        
        // creation's form while giving the entity
        $form = $this->createForm(WalkType::class, $walk);

        // ask to the form to examine the request object
         $form->handleRequest($request);

         //dd($walk);
 
         if ($form->isSubmitted() && $form->isValid()) {


            //update => date
            //$walk->setUpdatedAt(new \DateTime());
           
            // we ask to the Manager to save our object in our database
            $em->flush();

            $id = $walk->getId();

            // add a flash message to inform the user if his action is alright
            $this->addFlash('success', 'Vos modifications ont bien été pris en compte. <a href=\'http://localhost:8080/walk/'. $id .'\'>Retour vers la liste des randonnées</a>.');

            
            return $this->render('walk/edit.html.twig', [
                'walk' => $walk,
                'form' => $form->createView(),
            ]);
        }

       
        // display of the form => GET
        return $this->render('walk/edit.html.twig', [
            'walk' => $walk,
            'form' => $form->createView(),
        ]);
    }
}
