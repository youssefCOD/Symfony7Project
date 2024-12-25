<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
//this is were we get the Route
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        //we always return Response from http foundation
        return $this->render('home/index.html.twig', [
            //variables passed for display
            'controller_name' => 'HomeController',
            'test' => true ,
        ]);
    }
}
