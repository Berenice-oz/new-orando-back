<?php

namespace App\Controller\Api;

use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * Api endpoint to send an email to the website team
     * 
     * @param Request $request
     * @param MailerInterface $mailer
     * @return JSON
     * 
     * Get JSON Content in an array
     * 
     * Send an email with the data which are contained in the JsonContent and thank to the MailerInterface
     * @see https://symfony.com/doc/current/mailer.html
     *
     * @Route("/api/contact", name="api_contact", methods={"POST"})
     */
    public function contact(Request $request, MailerInterface $mailer)
    {
       $jsonContent = $request->toArray();
       $subject = $jsonContent['subject'];
       $mail = $jsonContent['mail'];
       $message = $jsonContent['message'];


        //Send mail
        $email = (new Email())
        ->from('contact@orando.me')
        ->to('contact@orando.me')
        ->replyTo($mail)
        ->subject('Contact Orando.me -' . $subject)
        ->text('Message de '.$mail .':
        '. $message);
        $mailer->send($email);

        return $this->json(['message' => 'Votre message a bien été envoyé.'], Response::HTTP_OK);
    }
}