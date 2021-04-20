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
     * Tag's list thank to TagRepository
     * 
     * Pass to the template tagsList object
     *
     * @Route("/back/tags", name="tag_browse", methods={"GET"})
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
     * @link https://symfony.com/doc/current/forms.html
     * 
     * Display the form and treat it
     * 
     * Create a new Tag
     * 
     * Then creation's form while giving the entity
     * 
     * Asking to the form to examine the request object
     * 
     * Saving the tag to the database thank to the EntityManagerInterface
     * 
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
     * Display the form and treat it
     * 
     * Check if the tag exist
     * 
     * Then creation's form while giving the entity
     * 
     * Asking to the form to examine the request object
     * 
     * Saving the tag to the database thank to the EntityManagerInterface
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
     * Check if the tag exist
     * 
     * Get back the token name which is in the form thank to Request object
     * and correponded to the second request(POST)
     * @link https://symfony.com/doc/current/security/csrf.html
     * 
     * Get the value of the CSRF token thank to 'delete_tag' which is generate on the display
     * 
     * Checking if the token store in delete_tag is Valid
     * 
     * Delete the tag
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

