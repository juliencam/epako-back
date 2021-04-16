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

class SubcategoryProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductCategory::class;
    }

    //@see ProductCategoryCrudController for comments
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setSearchFields(null);
    }

    //@see ProductCategoryCrudController for the comments
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->where("entity.parent IS NOT NULL");
        return $response;
    }

    public function configureFields(string $pageName): iterable
    {
        //callable to define a queryBuilder on a field of type associationField
        $parent = AssociationField::new('parent')->setRequired(true)
            ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
                return $productCategoryRepository->createQueryBuilder('pc')
                            ->where('pc.parent IS NULL')->andwhere("pc.name NOT LIKE '%endance%'");

            });

        $id = IntegerField::new('id');

        $name = Field::new('name');

         // @see imageCrudController for comments
        $imageField = TextareaField::new('imageFile')->setFormType(VichImageType::class)
        ->setTranslationParameters(['form.label.delete'=>'Supprimer'])
        ;

        if (Crud::PAGE_INDEX === $pageName) {

            return [$id, $name];

        } elseif (Crud::PAGE_EDIT === $pageName) {

            return [$name, $imageField, $parent ];

        }elseif (Crud::PAGE_NEW === $pageName) {

            return [$name, $imageField->setRequired(true), $parent ];

        }

    }
}
