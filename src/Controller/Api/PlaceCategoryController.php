<?php

namespace App\Controller\Api;

use App\Repository\PlaceCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/place/category")
 */

class PlaceCategoryController extends AbstractController
{
    /**
     * @Route("/browse", name="api_place_category_browse")
     */
    public function browse(PlaceCategoryRepository $placeCategoryRepository): Response
    {
        $placeCategory = $placeCategoryRepository->findAll();
        return $this->json($placeCategory,200,[], ['groups' => 'api_place_category_browse']);
    }
}
