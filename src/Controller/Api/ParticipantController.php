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
     * API endpoint to create a user's participation for a walk
     * 
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @return json
     * @link https://symfony.com/doc/current/components/serializer.html
     * 
     * Get the JSON content
     * 
     * Transform this JSON in Participant Entity with serializer
     * 
     * Save participation in database if there aren't errors
     * 
     * @Route("/api/participant", name="api_participant_create", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $jsonContent = $request->getContent();
        $participation = $serializer->deserialize($jsonContent, Participant::class, 'json');
        $errors = $validator->validate($participation);
        if (count($errors) > 0) {

            return $this->json(['message' => 'La modification n\'a pas été prise en compte.'], 418);
        }
        $entityManager->persist($participation);
        $entityManager->flush();
        return $this->json(
            ['message' => 'Votre participation à la randonnée a bien été prise en compte.'],
            Response::HTTP_CREATED
        );
    }

    /**
     * API endpoint to update a user's status participation to a walks
     * 
     * @param Request $request
     * @param ParticipantRepository $participantRepository
     * @param EntityManagerInterface $entityManager
     * @return json
     * @link https://symfony.com/doc/current/components/http_foundation.html#accessing-request-data
     * 
     * Get the JSON content and transform it in a array
     * 
     * Get the user and the walk in this array
     * 
     * Find the participation with Participant Repository
     * 
     * If is exist, update the participation status
     * 
     * @Route("/api/participant", name="api_participant_update", methods={"PATCH"})
     */
    public function update(Request $request, ParticipantRepository $participantRepository,EntityManagerInterface $entityManager)
    {
        $jsonContent = $request->toArray();
        $user = $jsonContent['user'];
        $walk = $jsonContent['walk'];
        $participant = $participantRepository->findOneBy(['user' => $user,'walk' => $walk]);
        if ($participant === null) {
            $message = [
                'error' => 'Participation non trouvée.',
                'status' => Response::HTTP_NOT_FOUND,
            ];

            return $this->json($message, Response::HTTP_NOT_FOUND);
        }
        $this->denyAccessUnlessGranted('update', $participant);
        $requestStatus = $jsonContent['requestStatus'];
        $participant->setRequestStatus($requestStatus);
        $entityManager->flush($participant);
        return $this->json(
            ['message' => 'Le statut de votre participation a bien été modifié.'],
            Response::HTTP_OK
        );
    }
}
