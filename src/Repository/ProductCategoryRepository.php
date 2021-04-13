<?php

namespace App\Repository;

use App\Entity\ProductCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductCategory[]    findAll()
 * @method ProductCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductCategory::class);
    }
    /**
     * @return ProductCategory
     */
     public function findAllProductCategory(): ?array
     {

         $entityManager = $this->getEntityManager();
         $query = $entityManager->createQuery(
            'SELECT p
             FROM App\Entity\ProductCategory p
             LEFT JOIN p.childCategories child
             WHERE p.parent IS NULL'
        );

         return $query->getResult();
     }

}
