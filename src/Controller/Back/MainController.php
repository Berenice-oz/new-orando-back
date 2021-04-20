<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * Back-Office home page
     *
     * @Route("/back", name="home", methods={"GET"})
     * 
     * @return Response
     */
    public function home()
    {
        return $this->render('back/home.html.twig');
    }
}