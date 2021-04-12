<?php

namespace App\Controller\Api;

use App\Repository\DepartmentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Route prefix
 * @Route("/api/department")
 */

class DepartmentController extends AbstractController
{
    /**
     * List Department
     * @Route("/browse", name="api_department_Browse" , methods="GET")
     */
    public function browse(DepartmentRepository $departmentRepository): Response
    {
        $department = $departmentRepository->findAll();
        return $this->json($department , 200, [], ['groups' => 'api_department_browse']);
    }
}
