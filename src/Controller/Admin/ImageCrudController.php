<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    // public function configureCrud(Crud $crud): Crud
    // {
    //     return $crud->setSearchFields(['product.name']);
    // }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->onlyOnIndex(),
            Field::new('name')->setRequired(true),
            Field::new('alt')->setRequired(true),
            TextareaField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms()->setRequired(true)
            ->setTranslationParameters(['form.label.delete'=>'Delete']),
            ChoiceField::new('displayOrder')->setChoices([0=> 0 , 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5]),
            AssociationField::new('product')->setRequired(true)
        ];
    }
}
