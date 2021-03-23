<?php

namespace App\Controller\Api;

use App\Entity\Area;
use App\Repository\AreaRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AreaController extends AbstractController
{
    /**
     * area's list
     * @Route("/api/areas", name="api_areas", methods={"GET"})
     */
    public function read(AreaRepository $areaRepository): Response
    {
        // We get back all areas
        $areas = $areaRepository->findAll();
        
        // We give data in Json format : 
        // first argument : data , second argument : status , 
        // third argument : an empty array, because we have NelmioCorsBundle
        // fourth argument : we have selected data we want to send thank to Symfony\Component\Serializer\Normalizer\AbstractNormalizer
        // which enable to write annotation (@Group) on properties in the Entity (Area)
        return $this->json(
            $areas,
            Response::HTTP_OK,
            [],
            ['groups' => 'api_area_read'],
        );
    }

    /**
     * Walk's list by area
     * @Route("/api/areas/{id<\d+>}", name="api_areas_read_item", methods="GET")
     */
    public function readItem(AreaRepository $areaRepository, Area $area = null)
    {   
        if ($area === null) {
            $message = [
                'error' => 'Area not found.',
                'status' => Response::HTTP_NOT_FOUND,
            ];

            return $this->json($message, Response::HTTP_NOT_FOUND);
        }

        // To get back walks'list by area ,I coded a custom method in the AreaRepository
        $walksByArea = $areaRepository->findAllWalkJoinedToArea($area);

        // we give in Json format
        return $this->json(
            $walksByArea,
            Response::HTTP_OK,
            [],
            ['groups' => 'api_area_read_item'],
        );
    }
}
