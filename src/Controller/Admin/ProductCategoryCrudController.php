<?php

namespace App\Controller\Admin;

use Doctrine\ORM\QueryBuilder;
use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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
     * check doc
     *https://stackoverflow.com/questions/63432424/symfony-easyadminbundle-3-override-the-createindexquerybuilder
     *Permet pour l'index de n'afiicher que les parents
     *
     */
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
    $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
    $response->where("entity.parent is null");
    return $response;
    }

    /**
     * selon la page
     * https://symfony.com/doc/current/bundles/EasyAdminBundle/fields.html#displaying-different-fields-per-page
     * 
     * setFormTypeOptions
     * https://symfony.com/doc/current/bundles/EasyAdminBundle/fields.html#misc-options
     */

    public function configureFields(string $pageName): iterable
    {
        $id = IntegerField::new('id')->onlyOnIndex();

        if (Crud::PAGE_NEW === $pageName) {
            $childCategories = AssociationField::new('childCategories')
            ->setHelp('Si vous ne choississez pas de child catégories, la catégorie en cours de création sera une catégorie')
            ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
                return $productCategoryRepository->createQueryBuilder('pc')
                            ->where('pc.parent IS NOT NULL');
            });
        }else {
            $childCategories = AssociationField::new('childCategories')
            ->setFormTypeOption('query_builder', function (ProductCategoryRepository $productCategoryRepository) {
                return $productCategoryRepository->createQueryBuilder('pc')
                            ->where('pc.parent IS NOT NULL');
            });
        }

        $name = Field::new('name');
        $pictogram = Field::new('pictogram');
        $places = AssociationField::new('places');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name];
         } elseif(Crud::PAGE_EDIT === $pageName || Crud::PAGE_NEW === $pageName) {
             return [$id, $name,$pictogram, $childCategories, $places ];
         }

        //https://symfony.com/doc/current/bundles/EasyAdminBundle/fields.html
        //return [
            // IntegerField::new('id')->onlyOnIndex(),
            // Field::new('name'),
            // Field::new('pictogram'),
            // IntegerField::new('price'),
            // IntegerField::new('status'),
            // Field::new('brand'),
            //AssociationField::new('images'),
            //AssociationField::new('parent'),
            // AssociationField::new('childCategories')->setFormTypeOption('query_builder', function(ProductCategoryRepository $productCategoryRepository){
            //     return $productCategoryRepository->createQueryBuilder('pc')
            //                 ->where('pc.parent IS NOT NULL');
            // }),
            // AssociationField::new('places'),
            //AssociationField::new('productCategories')
        //];
        
    }

//     public function editAction(AdminContext $context)
// {
//     $id     = $context->getRequest()->query->get('entityId');
//     $entity = $this->getDoctrine()->getRepository(Product::class)->find($id);

//     $clone = clone $entity;

//     // custom logic 
//     $clone->setEnabled(false);
//     // ...
//     $now = new DateTime();
//     $clone->setCreatedAt($now);
//     $clone->setUpdatedAt($now);

//     $this->persistEntity($this->get('doctrine')->getManagerForClass($context->getEntity()->getFqcn()), $clone);
//     $this->addFlash('success', 'Product duplicated');

//     return $this->redirect($this->get(CrudUrlGenerator::class)->build()->setAction(Action::INDEX)->generateUrl());
// }



}
