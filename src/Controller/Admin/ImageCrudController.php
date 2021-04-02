<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\LocaleField;
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

    /**
     * https://github.com/fre5h/VichUploaderSerializationBundle
     *
     * https://api-platform.com/docs/core/file-upload/#handling-file-upload
     * 
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->onlyOnIndex(),
            Field::new('name'),
            Field::new('alt'),
            //Field::new('url'),
            //ImageField::new('image')->onlyOnIndex(),//->setUploadDir('%app.path.product_images%'),
            //ImageField::new('imageFile')
            //->setFormType(VichImageType::class),//->setUploadDir('%app.path.product_images%')->onlyOnForms(),
            TextareaField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ChoiceField::new('displayOrder')->setChoices([0=> 0 , 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5]),
            AssociationField::new('product')
        ];
    }
}
