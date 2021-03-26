<?php

namespace App\Controller\Admin;

use App\Entity\Place;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Place::class;
    }

    public function configureFields(string $pageName): iterable
    {

        //https://symfony.com/doc/current/bundles/EasyAdminBundle/fields.html
        return [
            IntegerField::new('id')->onlyOnIndex(),
            Field::new('name'),
            Field::new('address'),
            Field::new('addressComplement'),
            Field::new('city'),
            Field::new('logo'),
            IntegerField::new('status'),
            // IntegerField::new('price'),
            // IntegerField::new('status'),
            // Field::new('brand'),
            //AssociationField::new('images'),
            AssociationField::new('department'),
            AssociationField::new('placeCategory'),
            //AssociationField::new('productCategories'),
            //AssociationField::new('productCategories')
        ];
    }
}
