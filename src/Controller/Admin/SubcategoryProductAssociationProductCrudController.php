<?php

namespace App\Controller\Admin;

use Doctrine\ORM\QueryBuilder;
use App\Entity\ProductCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SubcategoryProductAssociationProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setSearchFields(null);
    }


    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->where("entity.parent IS NOT NULL");
        return $response;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
        ;
    }


    public function configureFields(string $pageName): iterable
    {
        $id = IntegerField::new('id', "ID de la sous catégorie du produit")->setFormTypeOption('disabled','disabled');

        $name = Field::new('name', "nom de la sous catégorie du produit")->setFormTypeOption('disabled','disabled');

        $places = AssociationField::new('places');

        return [$id, $name, $places];

    }

}
