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


    public function configureFields(string $pageName): iterable
    {
        

            $id = IntegerField::new('id');
            $name = Field::new('name')->setRequired(true);
            $alt = Field::new('alt')->setRequired(true);
            //use of the Vichuploader bundle for image management
            //we should use the ImageField type instead of TextareaField but it triggers an error :
            //The "imageFile" image field must define the directory where the images
            //are uploaded using the setUploadDir() method.
            $image = TextareaField::new('imageFile')->setFormType(VichImageType::class)
            ->setTranslationParameters(['form.label.delete'=>'Supprimer']);
            $displayOrder = ChoiceField::new('displayOrder')
            ->setChoices([0=> 0 , 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5]);
            //fields for relationships
            $product = AssociationField::new('product')->setRequired(true);

            if (Crud::PAGE_INDEX === $pageName) {

                return [$id, $name];
    
            } elseif (Crud::PAGE_EDIT === $pageName) {
    
                return [$name, $alt, $image, $displayOrder, $product ];
    
            }elseif (Crud::PAGE_NEW === $pageName) {
    
                return [$name, $alt, $image->setRequired(true), $displayOrder, $product ];
    
            }
    }
}
