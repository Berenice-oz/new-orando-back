<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * Back-office : Users's list
     * 
     * @param UserRepository $userRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     * @link https://github.com/KnpLabs/KnpPaginatorBundle
     * 
     * Get all users or all users by search with UserRepository (QUERY not Result ==> @see UserRepository)
     * 
     * Paginate these datas into a Pagination object with KnpPaginatorBundle
     * 
     * Passing these paginates datas and render the template into the Response
     * 
     * @Route("/back/users", name="user_browse", methods={"GET"})
     */
    public function browse(UserRepository $userRepository, PaginatorInterface $paginator, Request $request)
    {
        $search = trim($request->query->get("search"));
        if ((strlen($search) < 2 && $search != null) || !($search)) {
            $usersListQuery = $userRepository->findAllQuery();
        } else {
            $usersListQuery = $userRepository->findAllUsersBySearchQuery($search);
        }
        $usersList = $paginator->paginate(
            $usersListQuery,
            $request->query->getInt('page', 1),
            10
        );
        $usersList->setCustomParameters([
            'align' => 'center',
            'size' => 'small',
        ]);
        return $this->render('back/user/browse.html.twig', [
            'usersList' => $usersList,
            'search' => $search,
        ]);
    }

    /**
     * Back-office : Delete a user
     * 
     * @param Request $request
     * @param mixed User $user
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     * @link https://symfony.com/doc/current/security/csrf.html
     * 
     * Check if the user exist
     * 
     * Get back the token name which is in the form thank to Request object
     * and correponded to the second request(POST)
     * 
     * Get the value of the CSRF token thank to 'delete_user' which is generate on the display
     * 
     * Checking if the token store in delete_user is Valid
     * 
     * Delete the user
     *
     * @Route("/back/user/{id<\d+>}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user = null, EntityManagerInterface $em)
    {
        if ($user === null) {

            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }
        $submittedToken = $request->request->get('token');
        if (!$this->isCsrfTokenValid('delete_user', $submittedToken)) {

            throw $this->createAccessDeniedException('Action non autorisée');
        }
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'Le profil de  ' . $user->getNickname() . ' a bien été supprimé.');

        return $this->redirectToRoute('user_browse');
    }
}
