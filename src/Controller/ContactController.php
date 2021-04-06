<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact_form", methods={"GET", "POST"})
     */
    public function form(Request $request, MailerInterface $mailer)
    {
        
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
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

            $this->addFlash('success', 'Merci pour votre message. Il sera traité dans les meilleurs délais.');

            return $this->redirectToRoute('contact_form');
            
        }else {
            return $this->render('contact/contact_form.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}