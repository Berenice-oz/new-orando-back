<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\UserContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response|RedirectResponse
     * 
     * @Route("/register", name="user_register", methods={"GET","POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            //$user->setStatus(1);
            //$user->setRoles(['ROLE_USER']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // add a flash message to inform the user if his action is alright
            $this->addFlash('success', 'Votre compte a bien été crée, vous pouvez vous connecter.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @param Request $request
     * @param MailerInterface $mailer
     * @param User $user
     * @return Response|RedirectResponse
     * 
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
            //Expeditor
            $expeditor = $this->getUser();
            //Send mail
            $email = (new TemplatedEmail());
            $email->getHeaders()->addTextHeader('X-Auto-Response-Suppress', 'OOF, DR, RN, NRN, AutoReply');
            $email->from(new Address('contact@orando.me'))
                ->to($recipientUserEmail)
                ->subject('O\'Rando - Vous avez reçu un nouveau message de ' . $expeditor->getNickname() . '!')
                ->htmlTemplate('email/email-contact_user.html.twig')
                ->text('Bonjour '.$user->getNickname().'

                Vous avez reçu un nouveau message de '.$expeditor->getNickname().' sur Orando.me :
                
                '.$message.'
                ')
                ->context([
                    'message' => $message,
                    'user' => $user,
                    'expeditor' => $expeditor
                ]);
            $mailer->send($email);
            $this->addFlash('success', 'Votre message a bien été envoyé. <a href=\'http://localhost:8080\'>Retour vers la liste des randonnées</a>.');

            //Redirection
            return $this->redirectToRoute('contact_user', ['id' => $user->getId()]);
        } else {
            return $this->render('user/contact.html.twig', [
                'form' => $form->createView(),
                'user' => $user,
            ]);
        }
    }
}
