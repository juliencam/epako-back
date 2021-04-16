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

        if (empty($options['attr']['placeImage'])) {
            $boolImageFileRequired = true;
        }

        $placeImage = !empty($options['attr']['placeImage']) ? $options['attr']['placeImage'] : 'Votre logo';

        $builder
            ->add('name')
            ->add('imageFile', VichImageType::class, [
                'required' => $boolImageFileRequired,
                'allow_delete' => false,
                //'delete_label' => '...',
                //'download_label' => 'download_file',
                'download_uri' => false,
                'image_uri' => true,
                'imagine_pattern' => false,
                'asset_helper' => false,
                'attr' => [
                    'value' => $placeImage,
                    "placeholder" => $placeImage
    
                    ],
                //'empty_data' => 'Default value'
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
