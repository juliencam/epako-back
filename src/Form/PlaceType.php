<?php

namespace App\Form;

use App\Entity\Place;
use App\Entity\PlaceCategory;
use App\Entity\ProductCategory;
use App\Repository\PlaceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use App\Repository\ProductCategoryRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PlaceType extends AbstractType
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
            ->add('address', TextType::class, [
                'required' => false,
            ])
            ->add('addressComplement', TextType::class, [
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'required' => false,
            ])

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

            ->add('status',ChoiceType::class,[
                    'choices' => [
                        'Actif' => 0,
                        'Inactif' => 1,
                    ],
                ])

            ->add('url', UrlType::class, [
                    'required' => false,
            ])

            ->add('content')
            ->add('department')

            //entity associated
            ->add('placeCategory' ,EntityType::class, [
                'class' => PlaceCategory::class,

                //sets the choice to a single option and becomes a selection tag
                'expanded' => false,
                'multiple' => false,

                'choice_label' => 'name',
            ])

            //association of product sub-categories with the place for the comparaison basket
            ->add('productCategories', EntityType::class,[
                'class' => ProductCategory::class,
                'required' => true,

                //sets the choice to multiple options and becomes a selection tag
                'expanded' => false,
                'multiple' => true,

                //Setting by_reference to false ensures that the setter is called in all cases.
                //essential for one to many relationships
                // @see https://symfony.com/doc/current/reference/forms/types/form.html#by-reference
                'by_reference' => false,

                //query builder to find product sub-categories
                'query_builder' => function (ProductCategoryRepository $er) {
                    return $er->createQueryBuilder('pc')
                        ->where('pc.parent IS NOT NULL');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Place::class,

        ]);
    }
}
