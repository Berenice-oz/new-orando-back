<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{
    /**
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response|RedirectResponse
     * 
     * @Route("/contact", name="contact_form", methods={"GET", "POST"})
     */
    public function form(Request $request, MailerInterface $mailer): Response
    {
        // creation's form 
        $form = $this->createForm(ContactType::class);

        // ask to the form to examine the request object
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // holding the submitted values
            $subject = $form->getData()['subject'];
            $mail = $form->getData()['mail'];
            $message = $form->getData()['message'];
            //dd($message);
        
            //Send mail
            $email = (new Email())
            ->from('contact@orando.me')
            ->to('contact@orando.me')
            ->replyTo($mail)
            ->subject('Contact Orando.me -' . $subject)
            ->text('Message de '.$mail .':
            '. $message);
            $mailer->send($email);

            // add a flash message to inform the user if his action is alright
            $this->addFlash('success', 'Merci pour votre message. Il sera traité dans les meilleurs délais.');

            // redirection
            return $this->redirectToRoute('contact_form');
            
        }else {
            // form view 
            return $this->render('contact/contact_form.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}