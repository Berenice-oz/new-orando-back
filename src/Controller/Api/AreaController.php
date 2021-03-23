<?php

namespace App\Controller\Api;

use App\Repository\AreaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AreaController extends AbstractController
{
    /**
     * area's list
     * @Route("/api/areas", name="api_area")
     */
    public function read(AreaRepository $areaRepository): Response
    {
        // We get back all areas
        $areas = $areaRepository->findAll();
        
        // We give data in json format : 
        // first argument : data , second argument : status , 
        // third argument : an empty array, because we have NelmioCorsBundle
        // fourth argument : we have selected data we want to send thank to Symfony\Component\Serializer\Normalizer\AbstractNormalizer
        // which enable to write annotation (@Group) on properties in the Entity (Area)
        return $this->json(
            $areas,
            Response::HTTP_OK,
            [],
            ['groups' => 'api_area'],
        );
    }
}
