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

}
