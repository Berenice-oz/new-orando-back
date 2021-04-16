<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * Users'list thank to the UserRepository
     * 
     * Pass the object usersList to the template
     * 
     * @param UserRepository $userRepository
     * @return Response
     * 
     * @Route("/back/users", name="user_browse", methods={"GET"})
     */
    public function browse(UserRepository $userRepository)
    {
        $usersList = $userRepository->findAll();

        return $this->render('back/user/browse.html.twig',[
            
            'usersList' => $usersList,
        ]);
    }

    /**
     * Delete a user
     * 
     * @param Request $request
     * @param mixed User $user
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     * 
     * Check if the user exist
     * 
     * Get back the token name which is in the form thank to Request object
     * and correponded to the second request(POST)
     * @link https://symfony.com/doc/current/security/csrf.html
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
       
        if($user === null){

        throw $this->createNotFoundException('Utilisateur non trouvé.');
      
       }

       $submittedToken = $request->request->get('user');

       if(!$this->isCsrfTokenValid('delete_user', $submittedToken)){
           
        throw $this->createAccessDeniedException('Action non autorisée');
       
       }

       $em->remove($user);
       $em->flush();

       $this->addFlash('success', 'Supression effectuée avec succès.');

       return $this->redirectToRoute('user_browse');
    }
}