<?php

namespace App\Controller\Api;

use App\Entity\Place;
use App\Entity\Department;
use App\Entity\ProductCategory;
use App\Repository\PlaceRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductCategoryRepository;
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

    //?
    //  /**
    //  * all Place for one department and one Product Category
    //  *
    //  * @Route("/browse/productcategory/{id<\d+>}/postalcode/{postalcode<^[1-9][0-9|a-b]$>}", name="api_place_browse_productcategory_postalcode", methods="GET")
    //  */
    // public function browsePlacebyOneProductCategory(ProductCategory  $productCategory = null, $postalcode ,PlaceRepository $placeRepository,Request $request): Response
    // {
    //
    //    if ($productCategory  === null) {
    //        $message = [
    //            'status' => Response::HTTP_NOT_FOUND,
    //            'error' =>'la categorie n\'existe pas',
    //        ];

    //         return $this->json($message,Response::HTTP_NOT_FOUND);
    //     }

    //     // Get postcode by request
    //      //$postalcode = $request->attributes->get('postalcode');


    //     $places = $placeRepository->findByProductCategoryAndPostalcode($productCategory, $postalcode );




    //     if($places == null ){
    //         $message = [
    //             'status' => Response::HTTP_NOT_FOUND,
    //             'error' =>'Il n\'y a pas de correspondance',
    //         ];

    //          return $this->json($message,Response::HTTP_NOT_FOUND);
    //     }
    //     return $this->json($places , 200,[], ['groups' => ['api_place_browse_ByproductcategoryAndPostalCode','api_place_read']]);
    // }



    /**
     * all Place for one department and many  Product Category
     * @Route("/browse/productcategory/{ids<\d+>}/postalcode/{postalcode<^[1-9][0-9|a-b]$>}", name="api_place_browse_productcategory_postalcode", methods="GET")
     * @Route("/browse/productcategory/{ids<^((\d+)\,?)+\d+$>}/postalcode/{postalcode<^[1-9][0-9|a-b]$>}", name="api_place_browse_productcategory_postalcode", methods="GET")
     */
    public function browsePlacebyManyProductCategory($ids, $postalcode ,PlaceRepository $placeRepository,ProductCategoryRepository $productCategoryRepository,Request $request): Response
    {

        //Todo make 404 for url if no match


        // transfrorm Get value  on an array
        $tabOfIds = explode(',', $ids);
        dump($tabOfIds);
        // search if the product category exist
        foreach($tabOfIds as $id) {

             $test = $productCategoryRepository->find($id);

             //404 ?
             if ($test === null) {
                     $message = [
                         'status' => Response::HTTP_NOT_FOUND,
                         'error' =>'une categorie n\'existe pas',
                     ];

                     return $this->json($message,Response::HTTP_NOT_FOUND);
                 }
        }





        $places = $placeRepository->findByProductCategory($tabOfIds,$postalcode);
        if($places == null ){
                $message = [
                    'status' => Response::HTTP_NOT_FOUND,
                    'error' =>'Il n\'y a pas de correspondance',
                    ];

                return $this->json($message,Response::HTTP_NOT_FOUND);
        }

        return $this->json($places, 200, [], ['groups' => ['api_place_browse_ByproductcategoryAndPostalCode','api_place_read']]);

    }


}
