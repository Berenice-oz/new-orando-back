<?php

namespace App\Controller\Back;

use App\Entity\Walk;
use App\Form\BackWalkType;
use App\Repository\WalkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WalkController extends AbstractController
{
    /**
     * Back-office : Walk's list
     *
     * @param WalkRepository $walkRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     * @link https://github.com/KnpLabs/KnpPaginatorBundle
     * 
     * Get all walks or all walks by search with WalkRepository (QUERY not Result ==> @see WalkRepository)
     * 
     * Paginate these datas into a Pagination object with KnpPaginatorBundle
     * 
     * Passing these paginates datas and render the template into the Response
     * 
     * @Route("/back/walks", name="back_walk_browse", methods={"GET"})
     */
    public function browse(WalkRepository $walkRepository, PaginatorInterface $paginator, Request $request)
    {
        $search = trim($request->query->get("search"));
        if ((strlen($search) < 2 && $search != null) || !($search)) {
            $walksListQuery = $walkRepository->findAllQuery();
        } else {
            $walksListQuery = $walkRepository->findAllWalksBySearchQuery($search);
        }
        $walksList = $paginator->paginate(
            $walksListQuery,
            $request->query->getInt('page', 1),
            10,
        );
        $walksList->setCustomParameters([
            'align' => 'center',
            'size' => 'small',
        ]);

        return $this->render('back/walk/browse.html.twig', [
            'walksList' => $walksList,
            'search' => $search,
        ]);
    }

    /**
     * BackOffice : Edit a walk (status) 
     *
     * @param mixed Walk $walk
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse
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
     * @Route("/back/walk/edit/{id<\d+>}", name="back_walk_edit", methods={"GET", "POST"})
     */
    public function edit(Walk $walk = null, Request $request, EntityManagerInterface $em)
    {
        if ($walk === null) {

            throw $this->createNotFoundException('Randonnée non trouvée');
        }
        $form = $this->createForm(BackWalkType::class, $walk);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', $walk->getTitle() . ' a bien été modifié.');

            return $this->redirectToRoute('back_walk_browse');
        }
        return $this->render('back/walk/edit.html.twig', [
            'walk' => $walk,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete a walk
     * 
     * @param mixed Walk $walk
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     * @link https://symfony.com/doc/current/security/csrf.html
     * 
     * Check if the walk exist
     * 
     * Get back the token name which is in the form thank to Request object
     * and correponded to the second request(POST)
     * 
     * Get the value of the CSRF token thank to 'delete_walk' which is generate on the display
     * 
     * Checking if the token store in delete_walk is Valid
     * 
     * Delete the walk
     *
     * @Route("/back/walk/{id<\d+>}", name="walk_delete", methods={"DELETE"})
     */
    public function delete(Walk $walk = null, Request $request, EntityManagerInterface $em)
    {
        if ($walk === null) {

            throw $this->createNotFoundException('Randonnée non trouvée.');
        }
        $submittedToken = $request->request->get('token');
        if (!$this->isCsrfTokenValid('delete_walk', $submittedToken)) {

            throw $this->createAccessDeniedException('Action non autorisée');
        }
        $em->remove($walk);
        $em->flush();
        $this->addFlash('success', 'La randonnée  ' . $walk->getTitle() . ' a bien été supprimée.');
        return $this->redirectToRoute('back_walk_browse');
    }
}
