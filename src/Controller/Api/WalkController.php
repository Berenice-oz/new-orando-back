<?php

namespace App\Controller\Api;

use App\Entity\Walk;
use App\Repository\WalkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WalkController extends AbstractController
{
     
    /**
     * API endpoint for listing walks
     * 
     * @param WalkRepository $walkRepository
     * @return JSON
     * 
     * Get all walks with WalkRepository
     * 
     * Return them in a JSON response
     * 
     * @Route("/api/walks", name="api_walks", methods={"GET"})
     */
    public function read(WalkRepository $walkRepository): Response
    {
        $walks = $walkRepository->findAll();
        return $this->json(
            $walks,
            Response::HTTP_OK,
            [],
            ['groups' => 'api_walks_read'],
        );
    }
   
    /**
     * API endpoint for reading a single walk's datas
     * 
     * @param mixed $walk
     * @param WalkRepository $walkRepository
     * @return JSON
     * 
     * Get the walk from params
     * 
     * If it exist, return walk's datas in a JSON Response
     * 
     * @Route("/api/walks/{id<\d+>}", name="api_walks_read_item", methods={"GET"})
     */
    public function readItem(Walk $walk = null): Response
    {
        // managing error
        if ($walk === null) {
            $message = [
                'error' => 'Walk not found.',
                'status' => Response::HTTP_NOT_FOUND,
            ]; 

            return $this->json($message, Response::HTTP_NOT_FOUND);
        }
        return $this->json(
            $walk,
            Response::HTTP_OK,
            [],
            [
                'groups' => 'api_walks_read_item',
                ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {

                    return $object->getId();
                }
            ]
        );
    }

    /**
     * API endpoint for deleting a walk
     * 
     * @param mixed $walk
     * @param EntityManagerInterface $em
     * @return JSON
     * 
     * Get the walk from params
     * 
     * If it exist, delete the walk with EntityManager
     * 
     * Return a JSON response
     * 
     * @Route("/api/walks/{id<\d+>}", name="api_walks_delete", methods={"DELETE"})
     */
    public function delete(Walk $walk = null, EntityManagerInterface $em)
    {
        if ($walk === null) {
            $message = [
                'status' => Response::HTTP_NOT_FOUND,
                'error' => 'Randonnée non trouvée.',
            ];

            return $this->json($message, Response::HTTP_NOT_FOUND);
        }
        $this->denyAccessUnlessGranted('delete', $walk);
        $walkId = $walk->getId();
        $em->remove($walk);
        $em->flush();
        $message = [
            'id' => $walkId,
            'message' => 'La randonnée a bien été supprimé.'
        ];
        return $this->json(
            $message,
            Response::HTTP_OK
        );
    }

    /**
     * Api endpoint for creating a walk
     * 
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     * 
     * Get the JSON Content
     * 
     * Transform this JSON in Walk Entity thank to the Serializer
     * 
     * Saving the walk which has been created in database if there are not some errors
     *
     * @Route("/api/walks", name="api_walks_create", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $em)
    {
        $jsonContent = $request->getContent();
        $walk = $serializer->deserialize(
            $jsonContent,
            Walk::class,
            'json',
            [
                'groups' => 'api_walks_read_item',
                ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                    return $object;
                }
            ]
        );
        $this->denyAccessUnlessGranted('create', $walk);
        $errors = $validator->validate($walk);
        if (count($errors) > 0) {
            $errorsList = [];
            foreach ($errors as $error) {
                $label = $error->getPropertyPath();
                $message = $error->getMessage();
                $errorsList[$label] =  $message;
            }

            return $this->json(['errors' => $errorsList], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $em->persist($walk);
        $em->flush();
        return $this->json(['message' => 'La randonnée à bien été crée.'], Response::HTTP_CREATED);
    }

    /**
     * Api endpoint for editing a walk
     * 
     * @param Request $request
     * @param mixed Walk $walk
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $em
     * @return JSON
     * 
     * Get the JSON Content
     * 
     * Transform this JSON in walk Entity thank to the Serializer
     * 
     * Using AbstractNormalizer allow to know which walk would be changed 
     * 
     * Saving in database the modifications on the walk if there are not some errors
     *
     * @Route("/api/walks/{id<\d+>}", name="api_walks_update", methods={"PATCH"})
     */
    public function update(Request $request, Walk $walk = null, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $em)
    {
        if ($walk === null) {

            return $this->json(['error' => 'Randonnée non trouvée'], Response::HTTP_NOT_FOUND);
        }
        $jsonContent = $request->getContent();
        $walk = $serializer->deserialize(
            $jsonContent,
            Walk::class,
            'json',
            [
                AbstractNormalizer::OBJECT_TO_POPULATE => $walk,
                'groups' => 'api_walks_read_item',
                ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                    return $object;
                }
            ]
        );
        $this->denyAccessUnlessGranted('update', $walk);
        $errors = $validator->validate($walk);
        if (count($errors) > 0) {
            $errorsList = [];
            foreach ($errors as $error) {
                $label = $error->getPropertyPath();
                $message = $error->getMessage();
                $errorsList[$label] =  $message;
            }

            return $this->json(['errors' => $errorsList], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $em->flush($walk);
        return $this->json(['message' => 'Randonnée modifiée.'], Response::HTTP_OK);
    }
}
