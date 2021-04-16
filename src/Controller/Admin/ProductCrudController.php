<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Repository\ProductCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
                                ->setRequired(true)->setHelp('Choisir une seule subcategory')
            ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
                return $productCategoryRepository->createQueryBuilder('pc')
                            ->where('pc.parent IS NOT NULL');//->orWhere("pc.name LIKE '%endance%'");
            });

            $id = IntegerField::new('id');
            $name = Field::new('name');
            $content = TextareaField::new('content');
            $price = IntegerField::new('price');
            $status = ChoiceField::new('status')->setChoices([0 => 0, 1 => 1])->setHelp('0 = actif / 1 = inactif');
            $brand = Field::new('brand');
            //@see PlaceCategoryCrudController for the comments of by_reference
            $image = AssociationField::new('images')->setFormTypeOption('by_reference', false);
            $tendanceBoolean = BooleanField::new('tendanceBoolean')->setHelp('Choisir si le produit est en tendance');

        if (Crud::PAGE_INDEX === $pageName) {

            return [$id, $name, $price, $brand];

        } elseif (Crud::PAGE_EDIT === $pageName) {

            return [$name, $price, $brand, $content, $status, $image, $subproductCategories, $tendanceBoolean];

        }elseif (Crud::PAGE_NEW === $pageName) {

            return [$name, $price, $brand, $content, $image->setRequired(true), $subproductCategories ];

        }
    }

}
