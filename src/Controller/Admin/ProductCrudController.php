<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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

        //https://symfony.com/doc/current/bundles/EasyAdminBundle/fields.html
        return [
            IntegerField::new('id')->onlyOnIndex(),
            Field::new('name'),
            TextareaField::new('content'),
            IntegerField::new('price'),
            IntegerField::new('status'),
            Field::new('brand'),
            AssociationField::new('images'),
            AssociationField::new('productCategories'),
            //AssociationField::new('productCategories')
        ];
    }

}
