<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * Form to contact a user and send message by mail
     * @Route("/profil/{id<\d+>}/contact-user", name="contact_user", methods={"GET","POST"})
     */
    public function userContact(Request $request, MailerInterface $mailer, User $user = null): Response
    {
        if ($user === null) {
            throw $this->createNotFoundException(
                'Utilisateur non trouvé'
            );
        }
        
        $form = $this->createForm(UserContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Message
            $message = $form->getData()['message'];
            //User's email
            $userEmail =  $user->getEmail();
            //Envoie du mail
            $email = (new Email())
            ->from('contact@orando.me')
            ->to('p.loukakou@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('You have a new message!')
            ->text('Sending emails is fun again!')
            ->html('<p>'. $message .'</p>');

        $mailer->send($email);
            //Flash message
            //Redirection
            return $this->redirectToRoute('contact_user', ['id' => $user->getId()]);
        }else {
            return $this->render('user/contact.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}
