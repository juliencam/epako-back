<?php

namespace App\Controller\Api;

use App\Entity\ProductCategory;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * ! Préfixe de route + ! Préfixe de nom de route
 * @Route("/api/product")
 */
class ProductCategoryController extends AbstractController
{

    const PATH = '/uploads/images/productcategorypictos/';
    const URL = 'http://';

    private $entityManager;
    private $productCategoryRepository;


    public function __construct(EntityManagerInterface $entityManager,ProductCategoryRepository $productCategoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->productCategoryRepository = $productCategoryRepository;

    }

    /**
     * List Product Category
     * @Route("/category/browse", name="api_product_category_browse", methods="GET")
     */
    public function browse(Request $request): Response
    {

        $productCategoryAllList = $this->productCategoryRepository->findAll();
        foreach ($productCategoryAllList as $productCategory) {


                $uri = $productCategory->getImage();
                //verifier $_SERVER['HTTP_HOST']
                // $request getbasepath
                $productCategory->setPictogram(self::URL .$request->server->get('SERVER_NAME').$request->server->get('BASE'). self::PATH . $uri);

                $this->entityManager->persist($productCategory);
                $this->entityManager->flush();

        }

        $productCategoryList = $this->productCategoryRepository->findAllProductCategory();
        return $this->json($productCategoryList, 200, [], ['groups' => 'api_product_category_browse']);
    }

    /**
     * One Product Category
     *
     * @Route("/category/read/{id<\d+>}", name="api_product_category_read", methods="GET")
     */
    public function read(ProductCategory $productCategory = null,Request $request): Response
    {
       // 404 ?
       if ($productCategory === null) {
           $message = [
               'status' => Response::HTTP_NOT_FOUND,
               'error' =>'la product categorie n\'existe pas',
           ];

            return $this->json($message,Response::HTTP_NOT_FOUND);
        }


        $productCategoryItem = $this->productCategoryRepository->find($productCategory);

        $uri = $productCategoryItem->getImage();
        $productCategoryItem->setPictogram(self::URL .$request->server->get('SERVER_NAME').$request->server->get('BASE'). self::PATH . $uri);

        $this->entityManager->persist($productCategoryItem);
        $this->entityManager->flush();


        return $this->json($productCategoryItem , 200, [], ['groups' => 'api_product_category_read']);
    }

    
}
