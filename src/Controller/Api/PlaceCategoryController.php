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
 * Route prefix
 * @Route("/api/place/category")
 */

class PlaceCategoryController extends AbstractController
{
    //path for storing images from the public folder.
    const PATH = '/uploads/images/placecategorypictos/';

    const URL = 'http://';

    private $entityManager;
    private $placeCategoryRepository;


    public function __construct(EntityManagerInterface $entityManager,PlaceCategoryRepository $placeCategoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->placeCategoryRepository = $placeCategoryRepository;

    }
    /**
     * List Place Category
     * @Route("/browse", name="api_place_category_browse", methods="GET")
     */
    public function browse(Request $request): Response
    {
        $placeCategories = $this->placeCategoryRepository->findAll();

        //loop to build the url that allows the front to retrieve the image from the back server
        foreach ($placeCategories as $placeCategory) {

            //retrieves the file name of the image
            $uri = $placeCategory->getImage();

            //SERVER_NAME is the name of the host server
            //BASE is the base URL
            $placeCategory->setPictogram(self::URL .$request->server->get('SERVER_NAME').$request->server->get('BASE'). self::PATH . $uri);

            $this->entityManager->persist($placeCategory);
            $this->entityManager->flush();

    }
        return $this->json($placeCategories,200,[], ['groups' => 'api_place_category_browse']);
    }

    /**
     * One Place Category
     *
     * @Route("/read/{id<\d+>}", name="api_place_category_read", methods="GET")
     */
    public function read(PlaceCategory $placeCategory = null,Request $request): Response
    {

       if ($placeCategory === null) {
           $message = [
               'status' => Response::HTTP_NOT_FOUND,
               'error' =>'la categorie alternative n\'existe pas',
           ];

            return $this->json($message,Response::HTTP_NOT_FOUND);
        }

        // @see browse method of PlaceCategoryController for the comments
        $placeCategoryItem = $this->placeCategoryRepository->find($placeCategory);
        $uri = $placeCategoryItem->getImage();
        $placeCategoryItem->setPictogram(self::URL .$request->server->get('SERVER_NAME').$request->server->get('BASE'). self::PATH . $uri);

        $this->entityManager->persist($placeCategoryItem);
        $this->entityManager->flush();
        return $this->json($placeCategoryItem , 200, [], ['groups' => 'api_place_category_read']);
    }


}
