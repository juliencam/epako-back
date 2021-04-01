<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Repository\ProductCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }
    

    public function configureFields(string $pageName): iterable
    {

        $productCategories = AssociationField::new('productCategories', 'subcategory')
            ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
                return $productCategoryRepository->createQueryBuilder('pc')
                            ->where('pc.parent IS NOT NULL');
            });


            // ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
            //     return $productCategoryRepository->createQueryBuilder('pc')
            //                 ->where('pc.parent IS NULL')->andwhere("pc.name LIKE '%endance%'")
            //                 ;
          
        //   $productCategoryTendance =  AssociationField::new('childCategories')
        //   ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
        //       return $productCategoryRepository->createQueryBuilder('pc')
        //                  ->where("pc.name LIKE '%endance%'");
        //   });


        //https://symfony.com/doc/current/bundles/EasyAdminBundle/fields.html
        return [
            IntegerField::new('id')->onlyOnIndex(),
            Field::new('name'),
            TextareaField::new('content')->hideOnIndex(),
            IntegerField::new('price'),
            ChoiceField::new('status')->setChoices([0 => 0, 1 => 1])->setHelp('0 = actif / 1 = inactif'),
            Field::new('brand'),
            AssociationField::new('images')->setFormTypeOption('by_reference', false)->hideOnIndex()->setRequired(true),
            // $productCategoryTendance,
            $productCategories//->setFormTypeOption('multiple',false)->setFormTypeOption('expanded', true)
            ->setRequired(true)->hideOnIndex(),
            //AssociationField::new('productCategories'),
        ];
    }

}
