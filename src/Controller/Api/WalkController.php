<?php

namespace App\Controller\Api;

use App\Repository\WalkRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;




class WalkController extends AbstractController
{
    /**
     * @Route("/api/walk", name="api_walk", methods={"GET"})
     */
    public function read(WalkRepository $walkRepository): Response
    {   
        // We send with json format walk data 
        
        $walks = $walkRepository->findAll();
        return $this->json(
            $walks,
            Response::HTTP_OK,
            [],
            ['groups' => 'api_walk'],
            
        );
    }
}
