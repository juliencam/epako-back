<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\Place;
use App\Entity\Product;
use App\Entity\Department;
use App\Entity\PlaceCategory;
use App\Entity\ProductCategory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use App\Controller\Admin\ProductTendanceCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin epako');
    }

    public function configureMenuItems():iterable
    {

        return
        [

            MenuItem::section('Product'),

            //Use of another crudController for the same entity
            MenuItem::linkToCrud('Product', 'fa fa-tags', Product::class)
            ->setController(ProductCrudController::class),
            MenuItem::linkToCrud('Category', 'fas fa-tags', ProductCategory::class)
            ->setController(ProductCategoryCrudController::class),
            MenuItem::linkToCrud('subCategory', 'fas fa-tags', PlaceCategory::class)
            ->setController(SubcategoryProductCrudController::class),
            MenuItem::linkToCrud('Image', 'fas fa-tags', Image::class),
            MenuItem::linkToCrud('Product Tendance', 'fa fa-tags', Product::class)
            ->setController(ProductTendanceCrudController::class),

            MenuItem::section('Place'),
            MenuItem::linkToCrud('Place', 'fas fa-tags', Place::class),
            MenuItem::linkToCrud('Category', 'fas fa-tags', PlaceCategory::class),
            MenuItem::linkToCrud('Department', 'fas fa-tags', Department::class),

            MenuItem::section('Association'),
            MenuItem::linkToCrud('Subproduct-Category & Place', 'fas fa-tags', PlaceCategory::class)
            ->setController(SubcategoryProductAssociationProductCrudController::class),
            MenuItem::section('User'),
            MenuItem::linkToCrud('User', 'fas fa-tags', User::class),

        ];
    }
}
