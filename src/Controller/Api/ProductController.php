<?php

namespace App\Controller\Api;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/api/product/browse", name="api_product_browse", methods="GET")
     */
    public function index(ProductRepository $ProductRepository): Response
    {
        $productList = $ProductRepository->findAll();
        dump($productList);
        return $this->json($productList, 200, [], ['groups' => 'api_product_browse']);
    }
}
