<?php

namespace App\Controller\Admin;

use App\Entity\PlaceCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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

            $id = IntegerField::new('id');
            $name = Field::new('name');
            // @see imageCrudController for comments
            $image = TextareaField::new('imageFile')->setFormType(VichImageType::class)
            ->setTranslationParameters(['form.label.delete'=>'Supprimer']);
            //Setting by_reference to false ensures that the setter is called in all cases.
            //essential for one to many relationships
            // @see https://symfony.com/doc/current/reference/forms/types/form.html#by-reference
            $places = AssociationField::new('places')->setFormTypeOption('by_reference', false);

            if (Crud::PAGE_INDEX === $pageName) {

                return [$id, $name, $places];
    
            } elseif (Crud::PAGE_EDIT === $pageName) {
    
                return [$name, $image,  $places ];
    
            }elseif (Crud::PAGE_NEW === $pageName) {
    
                return [$name, $image->setRequired(true),  $places ];
    
            }
       
    }
}
