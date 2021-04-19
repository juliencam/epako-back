<?php

namespace App\Controller\Admin;

use App\Entity\Place;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
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

        
           $id = IntegerField::new('id');
           $name = Field::new('name');
           $content = TextareaField::new('content')->setRequired(true);
           $address = Field::new('address');
           $addressComplement = Field::new('addressComplement');
           $city = Field::new('city')->setLabel("City / Système d'exploitation mobile" );
             // @see imageCrudController for comments
           $image = TextareaField::new('imageFile')->setFormType(VichImageType::class)
           ->setFormTypeOption('allow_delete', false);
           $status = ChoiceField::new('status')->setChoices([0 => 0, 1 => 1])->setHelp('0 = actif / 1 = inactif');
           $url = UrlField::new('url', 'URL Place')->hideOnIndex()->setRequired(true);
           $department = AssociationField::new('department')->setRequired(true);
           $placeCategory = AssociationField::new('placeCategory')->setRequired(true);

           if (Crud::PAGE_INDEX === $pageName) {

            return [$id, $name, $city, $department, $status];

            } elseif (Crud::PAGE_EDIT === $pageName) {

                return [$name, $content, $address, $addressComplement, $city, $image, $status, $url, 
                        $department, $placeCategory ];

            }elseif (Crud::PAGE_NEW === $pageName) {

                return [$name, $content, $address, $addressComplement, $city, $image->setRequired(true), 
                        $status, $url, $department, $placeCategory];

            }
        
    }
}
