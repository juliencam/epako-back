<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Repository\ProductCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {

        //callable to define a queryBuilder on a field of type associationField
        $subproductCategories = AssociationField::new('productCategories', 'subcategory')
            ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
                return $productCategoryRepository->createQueryBuilder('pc')
                            ->where('pc.parent IS NOT NULL');//->orWhere("pc.name LIKE '%endance%'");
            });


        return [
            IntegerField::new('id')->onlyOnIndex(),
            Field::new('name'),
            TextareaField::new('content')->hideOnIndex(),
            IntegerField::new('price'),
            ChoiceField::new('status')->setChoices([0 => 0, 1 => 1])->setHelp('0 = actif / 1 = inactif'),
            Field::new('brand'),
            //@see PlaceCategoryCrudController for the comments of by_reference
            AssociationField::new('images')->setFormTypeOption('by_reference', false)
            ->hideOnIndex(),
            $subproductCategories->setHelp('Choisir une seule subcategory')
            ->setRequired(true)->hideOnIndex(),
            BooleanField::new('tendanceBoolean')->onlyWhenUpdating()->setHelp('Choisir si le produit est en tendance')
        ];
    }

}
