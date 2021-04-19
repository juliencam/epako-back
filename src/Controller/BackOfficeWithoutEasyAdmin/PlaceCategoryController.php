<?php

namespace App\Controller\BackOfficeWithoutEasyAdmin;

use App\Entity\PlaceCategory;
use App\Form\PlaceCategoryType;
use App\Repository\PlaceCategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/backoffice/place/category")
 */
class PlaceCategoryController extends AbstractController
{
    /**
     * @Route("/browse", name="back_office_place_category_browse", methods={"GET"})
     */
    public function browse(PlaceCategoryRepository $placeCategoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        //use of PaginatorInterface (bundle KNP paginator) definition of the number of objects per page
        $pagination = $paginator->paginate(
            $placeCategoryRepository->findBy(
            [],
            ['updatedAt' => 'DESC']),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('back_office_without_easy_admin/place_category/browse.html.twig', [
            'place_categories' => $pagination,
        ]);
    }

    /**
     * @Route("/add", name="back_office_place_category_add", methods={"GET","POST"})
     */
    public function add(Request $request): Response
    {
        $placeCategory = new PlaceCategory();

        // creation of the form associated with the entity
        $form = $this->createForm(PlaceCategoryType::class, $placeCategory);

        //Inspection and handling of the request by the form
        $form->handleRequest($request);

        //If the form is submitted and validated
        if ($form->isSubmitted() && $form->isValid()) {

            //retrieves the EntityManager
            $entityManager = $this->getDoctrine()->getManager();

            //Persist the datas
            $entityManager->persist($placeCategory);

            //Save the datas
            $entityManager->flush();

            return $this->redirectToRoute('back_office_place_category_browse');
        }

        return $this->render('back_office_without_easy_admin/place_category/add.html.twig', [
            'place_category' => $placeCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/read/{id<\d+>}", name="back_office_place_category_read", methods={"GET"})
     * PlaceCategory is set to null to send a custom exception in the method if the object is null
     */
    public function read(PlaceCategory $placeCategory = null): Response
    {

        if (null === $placeCategory) {
            throw $this->createNotFoundException('PlaceCategory non trouvé.');
        }
        return $this->render('back_office_without_easy_admin/place_category/read.html.twig', [
            'place_category' => $placeCategory,
        ]);
    }

    /**
     * @Route("/edit/{id<\d+>}", name="back_office_place_category_edit", methods={"GET","POST"})
     * PlaceCategory is set to null to send a custom exception in the method if the object is null
     */
    public function edit(Request $request, PlaceCategory $placeCategory = null, PlaceCategoryRepository $placeCategoryRepository): Response
    {

        if (null === $placeCategory) {
            throw $this->createNotFoundException('PlaceCategory non trouvé.');
        }

        //finds a PlaceCategory by the id
        $placeCategoryObject =  $placeCategoryRepository->find($placeCategory);

        //finds the name of the image to send as a parameter to the form
        $placeCategoryImage = $placeCategoryObject->getImage();

        // creation of the form associated with the entity
        $form = $this->createForm(
            PlaceCategoryType::class,
            $placeCategory,
            ['attr' => ['placeImage' => $placeCategoryImage]]
        );

        //Inspection and handling of the request by the form
        $form->handleRequest($request);

        //If the form is submitted and validated
        if ($form->isSubmitted() && $form->isValid()) {

            //retrieves the EntityManager and Save the datas
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_office_place_category_browse');
        }

        return $this->render('back_office_without_easy_admin/place_category/edit.html.twig', [
            'place_category' => $placeCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id<\d+>}", name="back_office_place_category_delete", methods={"DELETE"})
     * PlaceCategory is set to null to send a custom exception in the method if the object is null
     */
    public function delete(Request $request, PlaceCategory $placeCategory = null, $id): Response
    {
        if (null === $placeCategory) {
            throw $this->createNotFoundException('Place category non trouvé.');
        }

        // @see https://symfony.com/doc/current/security/csrf.html#generating-and-checking-csrf-tokens-manually
        // Retrieves the name of the token that was deposited in the form
        $submittedToken = $request->request->get('_token');

        // if the token is not valid
        if (!$this->isCsrfTokenValid('delete'.$id, $submittedToken)) {

            throw $this->createAccessDeniedException('Are you token to me !??!??');
        }

        // if the token is valid
        if ($this->isCsrfTokenValid('delete'.$placeCategory->getId(), $request->request->get('_token'))) {

            //retrieves the EntityManager
            $entityManager = $this->getDoctrine()->getManager();

            //delete the current Object and save the datas
            $entityManager->remove($placeCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_office_place_category_browse');
    }
}
