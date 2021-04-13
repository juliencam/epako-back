<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Route prefix
 * @Route("/api/product")
 */

class ProductController extends AbstractController
{
    //path for storing images from the public folder.
    const PATH = '/uploads/images/products/';
    const URL = 'http://';
    private $entityManager;
    private $productRepository;


    public function __construct(EntityManagerInterface $entityManager,ProductRepository $productRepository)
    {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;

    }


    /**
     * List Product
     * @Route("/browse", name="api_product_browse", methods="GET")
     */
    public function browse( Product $product = null, Request $request): Response
    {

        // @see browse method of PlaceCategoryController for the comments
        $productList = $this->productRepository->findAll();

        foreach ($productList as $product) {

            $imageList = $product->getImages();

            foreach ($imageList as $image) {

                $uri = $image->getImage();

                $image->setUrl(self::URL .$request->server->get('SERVER_NAME').$request->server->get('BASE'). self::PATH . $uri);

            }

            $this->entityManager->persist($product);
            $this->entityManager->flush();

        }

        return $this->json($productList, 200, [], ['groups' => 'api_product_browse']);
    }
    /**
     * One Product
     *
     * @Route("/read/{id<\d+>}", name="api_product_read", methods="GET")
     */
    public function read(Product $product = null,Request $request): Response
    {

       if ($product === null) {
           $message = [
               'status' => Response::HTTP_NOT_FOUND,
               'error' =>'Il n\'existe pas de produit',
           ];

            return $this->json($message,Response::HTTP_NOT_FOUND);
        }


        $productItem = $this->productRepository->find($product);

        // @see browse method of PlaceCategoryController for the comments
        $imageList = $productItem ->getImages();

        foreach ($imageList as $image) {

            $uri = $image->getImage();

            $image->setUrl(self::URL .$request->server->get('SERVER_NAME').$request->server->get('BASE'). self::PATH . $uri);

        }
        $this->entityManager->persist($productItem);
        $this->entityManager->flush();
        return $this->json($productItem, 200, [], ['groups' => 'api_product_browse']);
    }


}
