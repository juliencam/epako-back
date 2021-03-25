<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends AbstractController
{
    /**
     * @Route("/api/department", name="api_department")
     */
    public function index(): Response
    {
        return $this->render('api/department/index.html.twig', [
            'controller_name' => 'DepartmentController',
        ]);
    }
}
