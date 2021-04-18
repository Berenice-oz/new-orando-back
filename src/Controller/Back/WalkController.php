<?php

namespace App\Controller\Back;

use App\Entity\Walk;
use App\Form\BackWalkType;
use App\Repository\WalkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WalkController extends AbstractController
{
    /**
     * Walks'list thank to the WalkRepository
     * 
     * Pass the object walksList to the template
     *
     * @param WalkRepository $walkRepository
     * @return Response
     * 
     * @Route("/back/walks", name="walk_browse", methods={"GET"})
     */
    public function browse(WalkRepository $walkRepository)
    {
       $walksList = $walkRepository->findAll();

       return $this->render('back/walk/browse.html.twig', [
           
        'walksList' => $walksList,
       
       ]);
    }

    /**
     * Update the status of a walk
     *
     * @param Request $request
     * @param mixed Walk $walk
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     * 
     * @Route("/back/walk/edit/{id<\d+>}", name="back_walk_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Walk $walk = null, EntityManagerInterface $em)
    {
        if($walk === null){

            throw $this->createNotFoundException('Randonnée non trouvée');

        }

        $form = $this->createForm(BackWalkType::class, $walk);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->flush();

            $this->addFlash('success', 'Modification éffectuée avec succès.');

            return $this->redirectToRoute('walk_browse');
        }


        return $this->render('back/walk/edit.html.twig', [
            'walk' => $walk,
            'form' => $form->createView(),
        ]);
    }
}