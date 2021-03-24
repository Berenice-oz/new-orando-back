<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * Form to contact a user and send message by mail
     * @Route("/profil/{id<\d+>}/contact-user", name="contact_user", methods={"GET","POST"})
     */
    public function userContact(Request $request, User $user): Response
    {
        if ($user === null) {
            throw $this->createNotFoundException(
                'Utilisateur non trouvé'
            );
        }
        
        $form = $this->createForm(UserContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Envoie du mail
            //Flash message
            //Redirection
        }else {
            return $this->render('user/contact.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}
