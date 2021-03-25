<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaceCategoryController extends AbstractController
{
    /**
     * @Route("/api/place/category", name="api_place_category")
     */
    public function index(): Response
    {
        return $this->render('api/place_category/index.html.twig', [
            'controller_name' => 'PlaceCategoryController',
        ]);
    }
}
