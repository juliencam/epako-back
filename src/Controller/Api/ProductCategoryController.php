<?php

namespace App\Controller\Api;

use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * ! Préfixe de route + ! Préfixe de nom de route
 * @Route("/api/product")
 */
class ProductCategoryController extends AbstractController
{
    /**
     * List Product Category
     * @Route("/category/browse", name="api_product_category_browse", methods="GET")
     */
    public function browse(ProductCategoryRepository $productCategoryRepository): Response
    {
        $productCategoryList = $productCategoryRepository->findAllProductCategory();

        return $this->json($productCategoryList, 200, [], ['groups' => 'api_product_category_browse']);
    }

    /**
     * One Product Category
     *
     * @Route("/category/read/{id<\d+>}", name="api_product_category_read", methods="GET")
     */
    public function read(ProductCategory $productCategory = null, ProductCategoryRepository $productCategoryRepository): Response
    {
       // 404 ?
       if ($productCategory === null) {
           $message = [
               'status' => Response::HTTP_NOT_FOUND,
               'error' =>'la product categorie n\'existe pas',
           ];

            return $this->json($message,Response::HTTP_NOT_FOUND);
        }


        $productCategoryItem = $productCategoryRepository->find($productCategory );
        return $this->json($productCategoryItem , 200, [], ['groups' => 'api_product_category_read']);
    }


}
