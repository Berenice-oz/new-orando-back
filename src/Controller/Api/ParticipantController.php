<?php

namespace App\Controller\Api;

use App\Entity\Participant;
use Doctrine\ORM\EntityManagerInterface;
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

            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        // Save the participation in database
        
        $entityManager->persist($participation);
        $entityManager->flush();

        return $this->json(
            ['message' => 'Votre participation à la randonnée a bien été prise en compte.'],
            Response::HTTP_CREATED
        );
    }
}
