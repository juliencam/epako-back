<?php

namespace App\Controller\BackOfficeWithoutEasyAdmin;

use App\Entity\Place;
use App\Form\PlaceType;
use App\Repository\PlaceRepository;
use App\Service\FirstLetterInUpperCase;
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
        //use of PaginatorInterface (bundle KNP paginator) definition of the number of objects per page
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
    public function add(Request $request, FirstLetterInUpperCase $firstLetterInUpperCase): Response
    {
        $place = new Place();

        // creation of the form associated with the entity
        $form = $this->createForm(PlaceType::class, $place);

        //Inspection and handling of the request by the form
        $form->handleRequest($request);

        //If the form is submitted and validated
        if ($form->isSubmitted() && $form->isValid()) {

            //gets the value of the form field for city
            $city = $form->get('city')->getData();

            //if city is not null
            if (!empty($city)) {

                //changes the boolean value of the environment variable so that
                //the FirstLetterInUpperCase service does not change the first letter to upper case
                //$firstLetterInUpperCase->setFirstLetterInUpperCase(false);

                //changes the first letter to uppercase
                $cityWithUpperCase = $firstLetterInUpperCase->changeFirstLetter($city);

                //changes the value of the current object
                $place->setCity($cityWithUpperCase);
            }

            //retrieves the EntityManager
            $entityManager = $this->getDoctrine()->getManager();

            //Persist the datas
            $entityManager->persist($place);

            //Save the datas
            $entityManager->flush();

            return $this->redirectToRoute('back_office_place_browse');
        }

        return $this->render('back_office_without_easy_admin/place/add.html.twig', [
            'place' => $place,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/read/{id<\d+>}", name="back_office_place_read", methods={"GET"})
     * Place is set to null to send a custom exception in the method if the object is null
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
     * @Route("/edit/{id<\d+>}", name="back_office_place_edit", methods={"GET","POST"})
     * Place is set to null to send a custom exception in the method if the object is null
     */
    public function edit(
        Request $request,
        Place $place = null,
        PlaceRepository $placeRepository,
        FirstLetterInUpperCase $firstLetterInUpperCase
        ): Response
    {
        if (null === $place) {
            throw $this->createNotFoundException('Place non trouvé.');
        }

        //finds a Place by the id
        $placeObject = $placeRepository->find($place);

        //finds the name of the image to send as a parameter to the form
        $placeImage = $placeObject->getImage();

        // creation of the form associated with the entity
        $form = $this->createForm(PlaceType::class, $place,['attr' => ['placeImage' => $placeImage]]);

        //Inspection and handling of the request by the form
        $form->handleRequest($request);

        //If the form is submitted and validated
        if ($form->isSubmitted() && $form->isValid()) {

            //gets the value of the form field for city
            $city = $form->get('city')->getData();

            //if city is not null
            if (!empty($city)) {

                //changes the boolean value of the environment variable so that
                //the FirstLetterInUpperCase service does not change the first letter to upper case
                //$firstLetterInUpperCase->setFirstLetterInUpperCase(false);

                //changes the first letter to uppercase
                $cityWithUpperCase = $firstLetterInUpperCase->changeFirstLetter($city);

                //changes the value of the current object
                $place->setCity($cityWithUpperCase);
            }

            //retrieves the EntityManager and save the datas
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_office_place_browse');
        }

        return $this->render('back_office_without_easy_admin/place/edit.html.twig', [
            'place' => $place,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id<\d+>}", name="back_office_place_delete", methods={"DELETE"})
     * Place is set to null to send a custom exception in the method if the object is null
     */
    public function delete(Request $request, Place $place = null, $id): Response
    {
        if (null === $place) {
            throw $this->createNotFoundException('Place non trouvé.');
        }

        // @see https://symfony.com/doc/current/security/csrf.html#generating-and-checking-csrf-tokens-manually
        // Retrieves the name of the token that was deposited in the form
        $submittedToken = $request->request->get('_token');

        // if the token is not valid
        if (!$this->isCsrfTokenValid('delete'.$id, $submittedToken)) {

            throw $this->createAccessDeniedException('Are you token to me !??!??');
        }

        // if the token is valid
        if ($this->isCsrfTokenValid('delete'.$place->getId(), $request->request->get('_token'))) {

            //retrieves the EntityManager
            $entityManager = $this->getDoctrine()->getManager();

            //delete the current Object and save the datas
            $entityManager->remove($place);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_office_place_browse');
    }
}
