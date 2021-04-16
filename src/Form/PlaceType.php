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

        if (empty($options['attr']['placeImage'])) {
            $boolImageFileRequired = true;
        }

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

            //si le nom de l'image n'est pas persisté c'est parce que imageFile n'est pas un champ
            // voir querybuilder, voir event, voir faire dump request, attention à ne pas mettre image qui contient 
            // l'unique ID, voir empty_data
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
            ])
            ->add('status',ChoiceType::class,[
                'choices' => [
                    'Actif' => 0,
                    'Inactif' => 1,
                ],
                //mettre valeur par defaut
                ])

            ->add('url', UrlType::class, [
                'required' => false,
            ])

            ->add('content')
            ->add('department')
            ->add('placeCategory' ,EntityType::class, [
                'class' => PlaceCategory::class,
                'expanded' => false,
                'multiple' => false,
                'choice_label' => 'name',
            ])
            ->add('productCategories', EntityType::class,[
                'class' => ProductCategory::class
                // 'constraints' => array(
                //     new Count(array(
                //         'max' => 1,
                //         'maxMessage' => 'At least only 1 choice is required',
                //     )),
                //)
                ,
                'required' => true,
                'expanded' => false,
                'multiple' => true,
                'by_reference' => false,
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
