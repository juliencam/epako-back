<?php

namespace App\Controller\Admin;

use App\Entity\PlaceCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlaceCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlaceCategory::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
