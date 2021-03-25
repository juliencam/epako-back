<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaceController extends AbstractController
{
    /**
     * @Route("/api/place", name="api_place")
     */
    public function index(): Response
    {
        return $this->render('api/place/index.html.twig', [
            'controller_name' => 'PlaceController',
        ]);
    }
}
