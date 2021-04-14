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
 * @Route("/backoffice/category")
 */
class PlaceCategoryController extends AbstractController
{
    /**
     * @Route("/browse", name="back_office_place_category_browse", methods={"GET"})
     */
    public function browse(PlaceCategoryRepository $placeCategoryRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $pagination = $paginator->paginate(
            $placeCategoryRepository->findBy([], ['updatedAt' => 'DESC']),
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
        $form = $this->createForm(PlaceCategoryType::class, $placeCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($placeCategory);
            $entityManager->flush();

            return $this->redirectToRoute('back_office_place_category_browse');
        }

        return $this->render('back_office_without_easy_admin/place_category/add.html.twig', [
            'place_category' => $placeCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("read/{id}", name="back_office_place_category_read", methods={"GET"})
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
     * @Route("edit/{id}", name="back_office_place_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PlaceCategory $placeCategory = null): Response
    {

        if (null === $placeCategory) {
            throw $this->createNotFoundException('PlaceCategory non trouvé.');
        }

        $form = $this->createForm(PlaceCategoryType::class, $placeCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_office_place_category_browse');
        }

        return $this->render('back_office_without_easy_admin/place_category/edit.html.twig', [
            'place_category' => $placeCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("delete/{id}", name="back_office_place_category_delete", methods={"POST"})
     */
    public function delete(Request $request, PlaceCategory $placeCategory = null, $id): Response
    {
        if (null === $placeCategory) {
            throw $this->createNotFoundException('Place non trouvé.');
        }

        // @see https://symfony.com/doc/current/security/csrf.html#generating-and-checking-csrf-tokens-manually
        // On réupère le nom du token qu'on a déposé dans le form
        $submittedToken = $request->request->get('_token');
        //dd($request->request);
        // 'delete-movie' is the same value used in the template to generate the token
        if (!$this->isCsrfTokenValid('delete'.$id, $submittedToken)) {
            // On jette une 403
            throw $this->createAccessDeniedException('Are you token to me !??!??');
        }

        if ($this->isCsrfTokenValid('delete'.$placeCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($placeCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_office_place_category_browse');
    }
}
