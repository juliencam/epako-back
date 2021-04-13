<?php

namespace App\Controller\Admin;

use App\Entity\PlaceCategory;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlaceCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlaceCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IntegerField::new('id')->onlyOnIndex(),
            Field::new('name'),
            // @see imageCrudController for comments
            TextareaField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms()
            ->setTranslationParameters(['form.label.delete'=>'Supprimer'])->setRequired(true),
            //Setting by_reference to false ensures that the setter is called in all cases.
            //essential for one to many relationships
            // @see https://symfony.com/doc/current/reference/forms/types/form.html#by-reference
            AssociationField::new('places')->setFormTypeOption('by_reference', false)
        ];
    }
}
