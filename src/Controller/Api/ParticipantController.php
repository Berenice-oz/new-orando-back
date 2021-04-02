<?php

namespace App\Controller\Api;

use App\Entity\Participant;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParticipantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ParticipantController extends AbstractController
{
    /**
     * User's Participation to a walk
     * @Route("/api/participant", name="api_participant_create", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        // Get JSON content
        $jsonContent = $request->getContent();
        // Transform this JSON in Participant Entity with serializer
        $participation = $serializer->deserialize($jsonContent, Participant::class, 'json');
        // Errors manager
        $errors = $validator->validate($participation);
        if (count($errors) > 0) {

            return $this->json(['message' => 'La modification n\'a pas été prise en compte.'], 418);
        }
        // Save the participation in database
        $entityManager->persist($participation);
        $entityManager->flush();

        return $this->json(
            ['message' => 'Votre participation à la randonnée a bien été prise en compte.'],
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/api/participant", name="api_participant_update", methods={"PATCH"})
     */
    public function update(Request $request, ParticipantRepository $participantRepository,EntityManagerInterface $entityManager)
    {
        //Récupérer le JSON
        $jsonContent = $request->toArray();
        //Récupérer le user et la randonnée
        $user = $jsonContent['user'];
        $walk = $jsonContent['walk'];
        //Chercher dans le Participant Repository l'entrée correspondante $participant
        $participant = $participantRepository->findOneBy(['user' => $user,'walk' => $walk]);
        //Si null return json404
        if ($participant === null) {
            $message = [
                'error' => 'Participation non trouvée.',
                'status' => Response::HTTP_NOT_FOUND,
            ];

            return $this->json($message, Response::HTTP_NOT_FOUND);
        }

        $this->denyAccessUnlessGranted('update', $participant);
        //Récupérer le status dans le JSON
        $requestStatus = $jsonContent['requestStatus'];
        //Modifier en BDD
        $participant->setRequestStatus($requestStatus);
        $entityManager->flush($participant);
        //Return json 200
        return $this->json(
            ['message' => 'Le statut de votre participation a bien été modifié.'],
            Response::HTTP_OK
        );
    }
}
