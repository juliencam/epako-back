<?php

namespace App\Controller\Admin;

use Doctrine\ORM\QueryBuilder;
use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductCategory::class;
    }

    /**
     * overloading of the createIndexQueryBuilder
     * method of the extended class AbstractCrudController by the crud.
     * Allow the index to display only the parents
     * @see https://stackoverflow.com/questions/63432424/symfony-easyadminbundle-3-override-the-createindexquerybuilder
     */
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->where("entity.parent is null");
        return $response;
    }

    /**
     * delete the search form
     * @see https://symfony.com/doc/current/bundles/EasyAdminBundle/crud.html#search-and-pagination-options
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setSearchFields(null);
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IntegerField::new('id');

        //callable to define a queryBuilder on a field of type associationField
        $childCategories = AssociationField::new('childCategories')
            ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
                return $productCategoryRepository->createQueryBuilder('pc')
                            ->where('pc.parent IS NOT NULL');
            //@see PlaceCategoryCrudController for the comments of by_reference
            })->setFormTypeOption('by_reference', false);


        $name = Field::new('name');
         // @see imageCrudController for comments
        $imageField = TextareaField::new('imageFile')->setFormType(VichImageType::class)
        ->setTranslationParameters(['form.label.delete'=>'Supprimer']);

        if (Crud::PAGE_INDEX === $pageName) {

            return [$id, $name];

        } elseif (Crud::PAGE_EDIT === $pageName) {

            return [$name, $imageField, $childCategories ];

        }elseif (Crud::PAGE_NEW === $pageName) {

            return [$name, $imageField->setRequired(true), $childCategories ];

        }

        //another way to define what is displayed according to the page
        // @see https://symfony.com/doc/current/bundles/EasyAdminBundle/fields.html#displaying-different-fields-per-page
        // if (Crud::PAGE_INDEX === $pageName) {
        //     return [$id, $name];
        // } elseif (Crud::PAGE_EDIT === $pageName || Crud::PAGE_NEW === $pageName) {
        //     return [$id, $name,$imageField, $childCategories ];
        // }
    }
}
