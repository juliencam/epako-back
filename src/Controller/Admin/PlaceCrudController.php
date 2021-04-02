<?php

namespace App\Controller\Admin;

use App\Entity\Place;
use App\Repository\ProductCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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
            TextareaField::new('content'),
            Field::new('address')->hideOnIndex(),
            Field::new('addressComplement')->hideOnIndex(),
            Field::new('city'),
            //Field::new('logo')->hideOnIndex(),
            //ImageField::new('image')->onlyOnIndex(),//->setUploadDir('%app.path.product_images%'),
            //ImageField::new('imageFile')
            //->setFormType(VichImageType::class),//->setUploadDir('%app.path.product_images%')->onlyOnForms(),
            TextareaField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ChoiceField::new('status')->setChoices([0 => 0, 1 => 1])->setHelp('0 = actif / 1 = inactif'),
            UrlField::new('url', 'URL Place')->hideOnIndex(),
            AssociationField::new('department'),
            AssociationField::new('placeCategory')->hideOnIndex(),
            // $childCategories,
        ];
    }
}
