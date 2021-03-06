<?php

namespace App\Controller\Api;

use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{   
    /**
     * Api endpoint for listing all tags
     *
     * @param TagRepository $tagRepository
     * @return JSON
     * 
     * Get all tags with TagRepository
     * 
     * Return them in a JSON response
     * 
     * @Route("/api/tags", name="api_tags", methods={"GET"})
     */
    public function read(TagRepository $tagRepository)
    {
        $tags = $tagRepository->findAll();

        return $this->json(
            $tags, 
            Response::HTTP_OK, 
            [],
            ['groups' => 'api_tags_read']
        );
    }
}