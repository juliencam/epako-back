<?php

namespace App\Controller\Api;

use App\Entity\PlaceCategory;
use App\Entity\ProductCategory;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlaceCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/place/category")
 */

class PlaceCategoryController extends AbstractController
{
    const PATH = '/uploads/images/placecategorypictos/';
    /**
     * List Place Category
     * @Route("/browse", name="api_place_category_browse", methods="GET")
     */
    public function browse(PlaceCategoryRepository $placeCategoryRepository,EntityManagerInterface $entityManager,
    Request $request): Response
    {
        $placeCategories = $placeCategoryRepository->findAll();
        foreach ($placeCategories as $placeCategory) {


            $uri = $placeCategory->getImage();
            $placeCategory->setPictogram($request->server->get('SERVER_NAME').$request->server->get('BASE'). self::PATH . $uri);

        $entityManager->persist($placeCategory);
        $entityManager->flush();

    }
        return $this->json($placeCategories,200,[], ['groups' => 'api_place_category_browse']);
    }

    /**
     * One Place Category
     *
     * @Route("/read/{id<\d+>}", name="api_place_category_read", methods="GET")
     */
    public function read(PlaceCategory $placeCategory= null, PlaceCategoryRepository $placeCategoryRepository ,EntityManagerInterface $entityManager,
    Request $request): Response
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
        $uri = $placeCategoryItem->getImage();
        $placeCategoryItem->setPictogram($request->server->get('SERVER_NAME').$request->server->get('BASE'). self::PATH . $uri);

        $entityManager->persist($placeCategoryItem);
        $entityManager->flush();
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
