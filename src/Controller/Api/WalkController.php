<?php

namespace App\Controller\Api;

use App\Entity\User;
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
     * @param WalkRepository $walkRepository
     * @return json
     * 
     * Walk's list
     * @Route("/api/walks", name="api_walks", methods={"GET"})
     */
    public function read(WalkRepository $walkRepository): Response
    {   
        // we get back all walks with findAll method 
        $walks = $walkRepository->findAll();
        
        // We send with json format walks datas 
        return $this->json(
            $walks,
            Response::HTTP_OK,
            [],
            ['groups' => 'api_walks_read'],
        );
    }

    /**
     * @param mixed $walk
     * @param WalkRepository $walkRepository
     * @return json
     * 
     * Data of a walk
     * @Route("/api/walks/{id<\d+>}", name="api_walks_read_item", methods={"GET"})
     */
    public function readItem(Walk $walk = null, WalkRepository $walkRepository):Response
    {
        // managing error
        if ($walk === null) {
            $message = [
                'error' => 'Walk not found.',
                'status' => Response::HTTP_NOT_FOUND,
            ];

            return $this->json($message, Response::HTTP_NOT_FOUND);
        }

        // we send walk item data json format
        return $this->json(
            $walk,
            Response::HTTP_OK,
            [],
            ['groups' => 'api_walks_read_item'],
        );
    }

    /**
     * @param mixed $walk
     * @param EntityManagerInterface $em
     * @return json
     * 
     * Delete a walk
     * @Route("/api/walks/{id<\d+>}", name="api_walks_delete", methods={"DELETE"})
     */
    public function delete(Walk $walk = null, EntityManagerInterface $em)
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

        // only the user who create a walk could be delete it (@see folder => Voter => WalkVoter.php)
        $this->denyAccessUnlessGranted('delete', $walk);
    
        // Delete a walk 
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
}
