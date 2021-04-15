<?php

namespace App\Controller\Back;

use App\Repository\TagRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{   
    /**
     * Back-office endpoint which is a list of tags 
     * 
     * @param TagRepository $tagRepository
     * @return Response
     *
     * @Route("/back/tag/browse", name="tag_browse", methods={"GET"})
     */
    public function browse(TagRepository $tagRepository)
    {
        $tagsList = $tagRepository->findAll();

        return $this->render('back/tag/browse.html.twig', [
            'tagsList' => $tagsList,
        ]);
    }

    
}

