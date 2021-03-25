<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\UserContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    
    /**
     * @Route("/register", name="user_register", methods={"GET","POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encodage du mot de passe
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            //todo flashmessage

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    
    /**
     * Form to contact a user and send message by mail
     * @Route("/profile/{id<\d+>}/contact-user", name="contact_user", methods={"GET","POST"})
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
            //Email content from form message
            $message = $form->getData()['message'];
            //User's email
            $userEmail =  $user->getEmail();
            //Send mail
            $email = (new Email())
            ->from('contact@orando.me')
            ->to($userEmail)
            ->subject('O\'Rando - You have a new message!')
            ->html('<p>'. $message .'</p>
            ');
            //todo penser à inclure dans le message du mail l'URL pour répondre $this->generateUrl('contact_user') + param id du user qui envoie le mail

        $mailer->send($email);
            //todo Flash message

            //Redirection
            return $this->redirectToRoute('contact_user', ['id' => $user->getId()]);
        }else {
            return $this->render('user/contact.html.twig', [
                'form' => $form->createView(),
                'user' => $user,
            ]);
        }
    }
}
