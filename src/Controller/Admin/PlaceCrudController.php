<?php

namespace App\Controller\Admin;

use App\Entity\Place;
use App\Repository\ProductCategoryRepository;
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

            // $childCategories = AssociationField::new('productCategories')
            // ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
            //     return $productCategoryRepository->createQueryBuilder('pc')
            //                 ->where('pc.parent IS NOT NULL');
            // });

        //https://symfony.com/doc/current/bundles/EasyAdminBundle/fields.html
        return [
            IntegerField::new('id')->onlyOnIndex(),
            Field::new('name'),
            Field::new('address')->hideOnIndex(),
            Field::new('addressComplement')->hideOnIndex(),
            Field::new('city'),
            Field::new('logo')->hideOnIndex(),
            IntegerField::new('status'),
            AssociationField::new('department'),
            AssociationField::new('placeCategory')->hideOnIndex(),
            // $childCategories,
        ];
    }
}
