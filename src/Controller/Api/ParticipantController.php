<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    /**
     * User's Participation to a walk
     * @Route("/api/participant", name="api_participant_create", methods={"POST"})
     */
    public function create(): Response
    {
        //todo récuperer l'id du user connecté et de la rando du json

        //todo Ajouter à l'entité un enregistrement, persister, flusher

        //todo envoyer une réponse json 200 ou erreur d'enregistrement

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Api/ParticipantController.php',
        ]);
    }
}
