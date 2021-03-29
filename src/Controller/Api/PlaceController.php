<?php

namespace App\Controller\Api;

use App\Entity\Place;
use App\Entity\Department;
use App\Entity\ProductCategory;
use App\Repository\PlaceRepository;
use Symfony\Component\HttpFoundation\Request;
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
     * List Place
     * @Route("/browse", name="api_place_browse")
     */
    public function browse(PlaceRepository $placeRepository): Response
    {

        $places = $placeRepository->findAll();
        return $this->json($places , 200, [], ['groups' => 'api_place_browse']);
    }

    /**
     * One Place
     *
     * @Route("/read/{id<\d+>}", name="api_place_read", methods="GET")
     */
    public function read(Place $place= null, PlaceRepository $placeRepository): Response
    {
       // 404 ?
       if ($place === null) {
           $message = [
               'status' => Response::HTTP_NOT_FOUND,
               'error' =>'Il n\'existe pas d\' alternative',
           ];

            return $this->json($message,Response::HTTP_NOT_FOUND);
        }


        $placeItem = $placeRepository->find($place);
        return $this->json($placeItem, 200, [], ['groups' => 'api_place_read']);
    }


     /**
     * all Place for one department and one Product Category
     *
     * @Route("/browse/productcategory/{array}/postalcode/{postalcode<^[1-9][0-9|a-b]$>}", name="api_place_browse_productcategory_postalcode", methods="GET")
     */
    public function browsePlacebyProductCategory($array,ProductCategory  $productCategory = null, $postalcode ,PlaceRepository $placeRepository,Request $request): Response
    {
        dump($array);
        $tab = explode(',' , $array);
        dump($tab);
       if ($productCategory  === null) {
           $message = [
               'status' => Response::HTTP_NOT_FOUND,
               'error' =>'la categorie n\'existe pas',
           ];

            return $this->json($message,Response::HTTP_NOT_FOUND);
        }

        // Get postcode by request
         //$postalcode = $request->attributes->get('postalcode');

         //$array = $request->attributes->get('array');
         //dump($array);

         dump($array);

             $places = $placeRepository->findByProductCategoryAndPostalcode($tab, $postalcode );




        if($places == null ){
            $message = [
                'status' => Response::HTTP_NOT_FOUND,
                'error' =>'Il n\'y a pas de correspondance',
            ];

             return $this->json($message,Response::HTTP_NOT_FOUND);
        }
        return $this->json($places , 200,[], ['groups' => ['api_place_browse_ByproductcategoryAndPostalCode','api_place_read']]);
    }
}
