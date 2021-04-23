<?php

namespace App\Controller\Back;

use App\Entity\Walk;
use App\Form\BackWalkType;
use App\Repository\WalkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
     * @Route("/back/walks", name="back_walk_browse", methods={"GET"})
     */
    public function browse(WalkRepository $walkRepository, PaginatorInterface $paginator, Request $request)
    {
        $search = trim($request->query->get("search"));
        if ((strlen($search) < 2 && $search != null )|| !($search)) {
            $walksListQuery = $walkRepository->findAllQuery();
        }else {
            $walksListQuery = $walkRepository->findAllWalksBySearchQuery($search);
        }
        $walksList = $paginator->paginate(
            $walksListQuery,
            $request->query->getInt('page', 1),
            10, /*limit per page*/
        );

        $walksList->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination and foundation_v6_pagination)
            'size' => 'small', # small|large (for template: twitter_bootstrap_v4_pagination)
        ]);

        return $this->render('back/walk/browse.html.twig', [
            'walksList' => $walksList,
            'search' => $search,
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
     * @param Request $request
     * @param mixed Walk $walk
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     * 
     * Check if the walk exist
     * 
     * Get back the token name which is in the form thank to Request object
     * and correponded to the second request(POST)
     * @link https://symfony.com/doc/current/security/csrf.html
     * 
     * Get the value of the CSRF token thank to 'delete_walk' which is generate on the display
     * 
     * Checking if the token store in delete_walk is Valid
     * 
     * Delete the walk
     *
     * @Route("/back/walk/{id<\d+>}", name="walk_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Walk $walk = null, EntityManagerInterface $em)
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
