<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {

        //https://symfony.com/doc/current/bundles/EasyAdminBundle/fields.html
        return [
            IntegerField::new('id')->onlyOnIndex(),
            EmailField::new('email'),
            ArrayField::new('roles'),
            Field::new('nickname'),
            IntegerField::new('status'),
            // Field::new('city'),
            // Field::new('logo'),
            // IntegerField::new('status'),
            // // IntegerField::new('price'),
            // IntegerField::new('status'),
            // Field::new('brand'),
            //AssociationField::new('images'),
            // AssociationField::new('department'),
            // AssociationField::new('placeCategory'),
            //AssociationField::new('productCategories'),
            //AssociationField::new('productCategories'),
            //AssociationField::new('productCategories')
        ];
    }
}
