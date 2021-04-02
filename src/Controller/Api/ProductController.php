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
 * ! Préfixe de route + ! Préfixe de nom de route
 * @Route("/api/product")
 */

class ProductController extends AbstractController
{

    const PATH = '/uploads/images/products/';

    /**
     * List Product
     * @Route("/browse", name="api_product_browse", methods="GET")
     */
    public function browse(
        Product $product = null,
        ProductRepository $ProductRepository,
        EntityManagerInterface $entityManager,
        Request $request
        ): Response
    {
        //dump($request->server->get('HTTP_HOST'));
        //dump($request->server->get('SERVER_NAME'));
        $productList = $ProductRepository->findAll();

        foreach ($productList as $product) {

            $imageList = $product->getImages();

            foreach ($imageList as $image) {

                $uri = $image->getImage();
                //verifier $_SERVER['HTTP_HOST']
                // $request getbasepath
                $image->setUrl($request->server->get('SERVER_NAME').$request->server->get('BASE'). self::PATH . $uri);

            }
            $entityManager->persist($product);
            $entityManager->flush();

        }

        return $this->json($productList, 200, [], ['groups' => 'api_product_browse']);
    }
    /**
     * One Product
     *
     * @Route("/read/{id<\d+>}", name="api_product_read", methods="GET")
     */
    public function read(Product $product = null, ProductRepository $ProductRepository, EntityManagerInterface $entityManager,
    Request $request): Response
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
        $imageList = $productItem ->getImages();

            foreach ($imageList as $image) {

                $uri = $image->getImage();
                //verifier $_SERVER['HTTP_HOST']
                // $request getbasepath
                $image->setUrl($request->server->get('SERVER_NAME').$request->server->get('BASE'). self::PATH . $uri);

            }
            $entityManager->persist($productItem );
            $entityManager->flush();
        return $this->json($productItem, 200, [], ['groups' => 'api_product_browse']);
    }

   
}
