<?php

namespace App\Controller\BackOfficeWithoutEasyAdmin;

use App\Entity\Place;
use App\Form\PlaceType;
use App\Repository\PlaceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/backoffice/place")
 */
class PlaceController extends AbstractController
{
    /**
     * @Route("/browse", name="back_office_place_browse", methods={"GET"})
     */
    public function browse(PlaceRepository $placeRepository,PaginatorInterface $paginator,Request $request): Response
    {

        $pagination = $paginator->paginate(
            $placeRepository->findBy([], ['updatedAt' => 'DESC']),
            $request->query->getInt('page', 1),
            15
        );
        return $this->render('back_office_without_easy_admin/place/browse.html.twig', [
            'places' => $pagination,
        ]);
    }

    /**
     * @Route("/add", name="back_office_place_add", methods={"GET","POST"})
     */
    public function add(Request $request): Response
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($place);
            $entityManager->flush();

            return $this->redirectToRoute('back_office_place_browse');
        }

        return $this->render('back_office_without_easy_admin/place/add.html.twig', [
            'place' => $place,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/read/{id}", name="back_office_place_read", methods={"GET"})
     */
    public function read(Place $place = null): Response
    {
        if (null === $place) {
            throw $this->createNotFoundException('Place non trouvé.');
        }
        return $this->render('back_office_without_easy_admin/place/read.html.twig', [
            'place' => $place,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="back_office_place_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Place $place = null,PlaceRepository $placeRepository): Response
    {
        if (null === $place) {
            throw $this->createNotFoundException('Place non trouvé.');
        }

        $placeObject =  $placeRepository->find($place);
        $placeImage = $placeObject->getImage();
        $form = $this->createForm(PlaceType::class, $place,['attr' => ['placeImage' => $placeImage]]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_office_place_browse');
        }

        return $this->render('back_office_without_easy_admin/place/edit.html.twig', [
            'place' => $place,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="back_office_place_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Place $place = null, $id): Response
    {
        if (null === $place) {
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

        if ($this->isCsrfTokenValid('delete'.$place->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($place);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_office_place_browse');
    }
}
