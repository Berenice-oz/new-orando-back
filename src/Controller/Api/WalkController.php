<?php

namespace App\Controller\Api;

use App\Entity\Walk;
use App\Repository\WalkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class WalkController extends AbstractController
{
    /**
     * Walk's list
     * @Route("/api/walks", name="api_walks", methods={"GET"})
     */
    public function read(WalkRepository $walkRepository): Response
    {   
        // We send with json format walks datas 
        $walks = $walkRepository->findAll();
        return $this->json(
            $walks,
            Response::HTTP_OK,
            [],
            ['groups' => 'api_walks_read'],
        );
    }

    /**
     * Data of a walk
     * @Route("/api/walks/{id<\d+>}", name="api_walks_read_item", methods={"GET"})
     */
    public function readItem(Walk $walk = null):Response
    {
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
            ['groups' => 'api_walks_read_item'],
        );
    }

    /**
     * Delete a walk
     * @Route("/api/walks/delete/{id<\d+>}", name="api_walks_delete_item", methods={"DELETE"})
     */
    public function deleteItem(Walk $walk, EntityManagerInterface $em)
    {
        // managing error
        if ($walk === null) {

            // optional: we define a custom message to transmit to the frontend
            $message = [
                'status' => Response::HTTP_NOT_FOUND,
                'error' => 'Randonnée non trouvée.',
            ];
    
           
            return $this->json($message, Response::HTTP_NOT_FOUND);
        }
    
    
            // Delete
            $em->remove($walk);
            $em->flush();
    
            
            return $this->json(
            ['message' => 'La randonnée a bien été supprimé.'],
            Response::HTTP_OK
            );
    }
}
