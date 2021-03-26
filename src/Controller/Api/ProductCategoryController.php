<?php

namespace App\Controller\Api;

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
}
