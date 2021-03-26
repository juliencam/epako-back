<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * ! Préfixe de route + ! Préfixe de nom de route
 * @Route("/api/product")
 */

class ProductController extends AbstractController
{
    /**
     * List Product
     * @Route("/browse", name="api_product_browse", methods="GET")
     */
    public function browse(ProductRepository $ProductRepository): Response
    {
        $productList = $ProductRepository->findAll();

        return $this->json($productList, 200, [], ['groups' => 'api_product_browse']);
    }
    /**
     * One Product
     *
     * @Route("/read/{id<\d+>}", name="api_product_read", methods="GET")
     */
    public function read(Product $product = null, ProductRepository $ProductRepository): Response
    {
       // 404 ?
       if ($product === null) {
           $message = [
               'status' => Response::HTTP_NOT_FOUND,
               'error' =>'Il n\'existe pas de produit',
           ];

            return $this->json($message,Response::HTTP_NOT_FOUND);
        }


        $productItem = $ProductRepository->find($product);
        return $this->json($productItem, 200, [], ['groups' => 'api_product_browse']);
    }
}
