<?php

namespace App\Controller\Api;

use App\Entity\PlaceCategory;
use App\Entity\ProductCategory;
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
     * List Place Category
     * @Route("/browse", name="api_place_category_browse")
     */
    public function browse(PlaceCategoryRepository $placeCategoryRepository): Response
    {
        $placeCategory = $placeCategoryRepository->findAll();
        return $this->json($placeCategory,200,[], ['groups' => 'api_place_category_browse']);
    }

    /**
     * One Place Category
     *
     * @Route("/read/{id<\d+>}", name="api_place_category_read", methods="GET")
     */
    public function read(PlaceCategory $placeCategory= null, PlaceCategoryRepository $placeCategoryRepository): Response
    {
       // 404 ?
       if ($placeCategory === null) {
           $message = [
               'status' => Response::HTTP_NOT_FOUND,
               'error' =>'la categorie alternative n\'existe pas',
           ];

            return $this->json($message,Response::HTTP_NOT_FOUND);
        }


        $placeCategoryItem = $placeCategoryRepository->find($placeCategory);
        return $this->json($placeCategoryItem , 200, [], ['groups' => 'api_place_category_read']);
    }
     // Todo  a faire  ou pas
     /**
     * all Place for one department and on Product Category
     *
     * @Route("/browse/productcategory/{id<\d+>}", name="api_place_category_browse_productcategory_postalcode", methods="GET")
     */
    public function browsePlacebyProductCategory(ProductCategory $productCategory,PlaceCategoryRepository $placeCategoryRepository): Response
    {

    //    // 404 ?
    //    if ($place === null) {
    //        $message = [
    //            'status' => Response::HTTP_NOT_FOUND,
    //            'error' =>'Pas de place par ici ',
    //        ];

    //         return $this->json($message,Response::HTTP_NOT_FOUND);
    //     }


        $places = $placeCategoryRepository->findAllPlaceByProductCategoryAndPostalcode($productCategory);
        // Le 4ème argument représente le "contexte"
        // qui sera transmis au Serializer
        return $this->json($places , 200,[], ['groups' => 'api_placecategory_browse_productcategory']);
    }
}
