<?php

namespace App\Form;

use App\Entity\PlaceCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaceCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $boolImageFileRequired = false;

        //if the image name of the current object is empty, the form field for imageFile will be required
        if (empty($options['attr']['placeImage'])) {
            $boolImageFileRequired = true;
        }

        //definition of the placeholder and value of the form field for imageFile  depending on whether the
        //image name of the current object is empty or not
        $placeImage = !empty($options['attr']['placeImage']) ? $options['attr']['placeImage'] : 'Votre logo';

        $builder
            ->add('name')
            //fields to upload the image file, fields to link to the vichuploader bundle
            ->add('imageFile', VichImageType::class, [
                'required' => $boolImageFileRequired,
                //removes the button to delete the image
                'allow_delete' => false,
                //removes the link to download the image
                'download_uri' => false,

                //config for LIIP bundle
                //'imagine_pattern' => false,
                'attr' => [
                    'value' => $placeImage,
                    "placeholder" => $placeImage
                    ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlaceCategory::class,
        ]);
    }
}
