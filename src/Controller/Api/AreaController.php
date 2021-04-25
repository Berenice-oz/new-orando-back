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
     * API endpoint for listing areas and theirs walks
     * 
     * @param AreaRepository $areaRepository
     * @return JSON
     * 
     * Get all areas with their walks with AreaRepository
     * 
     * Return them in a JSON response
     * 
     * @Route("/api/areas", name="api_areas", methods={"GET"})
     */
    public function read(AreaRepository $areaRepository): Response
    {
        $areas = $areaRepository->findAllWithWalk();
        return $this->json(
            $areas,
            Response::HTTP_OK,
            [],
            ['groups' => [
                'api_area_read', 
                'api_area_read_item'
            ]]
        );
    } 

    /**
     * API endpoint for reading a single area's datas
     * 
     * @param AreaRepository $areaRepository
     * @param Area $area
     * @return JSON
     * 
     * Get the area from params
     * 
     * If it exist, find area datas and related walks with AreaRepository.
     * 
     * Return these datas in a JSON Response
     * 
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
        $walksByArea = $areaRepository->findAllWalkJoinedToArea($area);
        return $this->json(
            $walksByArea,
            Response::HTTP_OK,
            [],
            ['groups' => 'api_area_read_item'],
        );
    }
}
