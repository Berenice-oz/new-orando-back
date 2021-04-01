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
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $user->setStatus(1);
            $user->setRoles(['ROLE_USER']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // add a flash message to inform the user if his action is alright
            $this->addFlash('success', 'Votre compte a bien été crée, vous pouvez vous connecter.');

            return $this->redirectToRoute('app_login');
        }
        //Todo ELSE une erreur est survenue lors de l'enregistrement

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
        //make sure the user is authenticated first
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
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
            $recipientUserEmail =  $user->getEmail();
            //Sender email
            $senderUserEmail = $this->getUser()->getEmail();
            //Send mail
            $email = (new Email())
            ->from($senderUserEmail)
            ->to($recipientUserEmail)
            ->subject('O\'Rando - You have a new message from '. $this->getUser()->getNickname() .'!')
            ->html('<p>'. $message .'</p>
            <p>Pour répondre rendez vous sur la page :'.$this->generateUrl('contact_user', ['id' => $this->getUser()->getId()]).'</p>');
            //todo penser à inclure dans le message du mail l'URL pour répondre $this->generateUrl('contact_user') + param id du user qui envoie le mail

        $mailer->send($email);
            //todo Flash message
            $this->addFlash('success', 'Votre message a bien été envoyé. <a href=\'http://localhost:8080\'>Retour vers la liste des randonnées</a>.');

            //Redirection
            //! impossible d'envoyer vers la page profil de l'utilisateur connecté
            //! car pas de paramètre d'url(id) coté front 
            return $this->redirectToRoute('contact_user', ['id' => $user->getId()]);
        }else {
            return $this->render('user/contact.html.twig', [
                'form' => $form->createView(),
                'user' => $user,
            ]);
        }
    }
}
