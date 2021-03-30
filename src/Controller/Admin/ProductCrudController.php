<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Repository\ProductCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use phpDocumentor\Reflection\Types\Integer;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }
    

    public function configureFields(string $pageName): iterable
    {

        $productCategories = AssociationField::new('productCategories')
            ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
                return $productCategoryRepository->createQueryBuilder('pc')
                            ->where('pc.parent IS NOT NULL')->orwhere("pc.name LIKE '%endance%'")
                            ;
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
            AssociationField::new('images')->hideOnIndex()->setFormTypeOption('disabled','disabled'),
            // $productCategoryTendance,
            $productCategories->setRequired(true)->hideOnIndex(),
            //AssociationField::new('productCategories')
        ];
    }

}
