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
            TextareaField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms()
            ->setTranslationParameters(['form.label.delete'=>'Delete'])->setRequired(true),
            AssociationField::new('places')->setFormTypeOption('by_reference', false)->setRequired(true)
        ];
    }
}
