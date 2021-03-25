<?php

namespace App\Controller\Admin;

use App\Entity\Place;
use App\Entity\Review;
use App\Entity\Product;
use App\Entity\Department;
use App\Entity\PlaceCategory;
use App\Entity\ProductCategory;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
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

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Product');
        yield MenuItem::linkToCrud('Products', 'fas fa-tags', Product::class);
        yield MenuItem::linkToCrud('Category Product', 'fas fa-tags', ProductCategory::class);
        yield MenuItem::section('Place');
        yield MenuItem::linkToCrud('Place', 'fas fa-tags', Place::class);
        yield MenuItem::linkToCrud('Place Category', 'fas fa-tags', PlaceCategory::class);
        yield MenuItem::linkToCrud('Department', 'fas fa-tags', Department::class);
        yield MenuItem::linkToCrud('Review', 'fas fa-tags', Review::class);
        yield MenuItem::section('User');
        yield MenuItem::linkToCrud('User', 'fas fa-tags', User::class);
    }
}
