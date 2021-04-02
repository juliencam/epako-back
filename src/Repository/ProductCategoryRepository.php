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
     *
     *
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

     public function findAllProductCategoryQb()
     {

        return $this->createQueryBuilder('p')
    ;
     }
    // 'SELECT c, p,m
    // FROM App\Entity\MovieCast c
    // INNER JOIN c.person p
    // INNER JOIN c.movie m
    // WHERE m.id = :id'


    // SELECT *,`person`.*,`movie`.* FROM `movie_cast`
//  INNER JOIN `movie`  ON `movie_cast`.`movie_id` = `movie`.`id`
//  INNER JOIN `person` ON `movie_cast`.`person_id` = `person`.`id`

    // /**
    //  * @return ProductCategory[] Returns an array of ProductCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductCategory
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
