<?php

namespace App\Controller\Api;

use App\Repository\PlaceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * ! Préfixe de route + ! Préfixe de nom de route
 * @Route("/api/place")
 */


class PlaceController extends AbstractController
{
    /**
     * @Route("/browse", name="api_place_browse")
     */
    public function browse(PlaceRepository $placeRepository): Response
    {

        $place = $placeRepository->findAll();
        return $this->json($place , 200, [], ['groups' => 'api_place_browse']);
    }
}
