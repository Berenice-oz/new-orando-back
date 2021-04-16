<?php

namespace App\Controller\Back;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{   
    /**
     * Back-office endpoint which is a list of tags 
     * 
     * @param TagRepository $tagRepository
     * @return Response
     *
     * @Route("/back/tag/browse", name="tag_browse", methods={"GET"})
     */
    public function browse(TagRepository $tagRepository)
    {
        $tagsList = $tagRepository->findAll();

        return $this->render('back/tag/browse.html.twig', [
            'tagsList' => $tagsList,
        ]);
    }


    /**
     * BackOffice : Add a new tag
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response|RedirectResponse
     *
     * @Route("/back/tag/add", name="tag_add", methods={"GET", "POST"})
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $tag = new Tag();

        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($tag);

            $em->flush();

            $this->addFlash('success', 'Ajout éffectué avec succès.');

            return $this->redirectToRoute('tag_browse');


        }

        return $this->render('back/tag/add.html.twig',[
            
            'form' => $form->createView()
        ]);
    }

    /**
     * BackOffice : Edit a Tag
     * 
     * @param mixed Tag $tag
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response|RedirectResponse
     *
     * @Route("/back/tag/edit/{id<\d+>}", name="tag_edit", methods={"GET", "POST"})
     */
    public function edit(Tag $tag = null , Request $request, EntityManagerInterface $em)
    {
        
        if($tag === null){

            throw $this->createNotFoundException('Tag non trouvé.');
        }
        
        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->flush();

            $this->addFlash('success', 'Modification éffectuée avec succès.');

            return $this->redirectToRoute('tag_browse');


        }

        return $this->render('back/tag/edit.html.twig',[
            'tag' => $tag,
            'form' => $form->createView(),
        ]);


    }

    /**
     * BackOffice : Delete a Tag
     *
     * @Route("/back/tag/delete/{id<\d+>}", name="tag_delete", methods={"DELETE"})
     */
    public function delete(Tag $tag = null, Request $request, EntityManagerInterface $em)
    {
        if($tag === null){

            throw $this->createNotFoundException('Tag non trouvé.');
        }

        $submittedToken = $request->request->get('token');

        if(!$this->isCsrfTokenValid('delete_tag', $submittedToken)){
            
            throw $this->createAccessDeniedException('Action non autorisée.');
        }

        $em->remove($tag);
        $em->flush();

        $this->addFlash('success', 'Suppression du tag effectuée.');

        return $this->redirectToRoute('tag_browse');
    }
    
}

