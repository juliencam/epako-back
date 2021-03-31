<?php

namespace App\Controller\Admin;

use App\Entity\PlaceCategory;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class PlaceCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlaceCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {

        //https://symfony.com/doc/current/bundles/EasyAdminBundle/fields.html
        return [
            IntegerField::new('id')->onlyOnIndex(),
            Field::new('name'),
            Field::new('pictogram'),
            AssociationField::new('places')->setFormTypeOption('by_reference', false)
        ];
    }
}
