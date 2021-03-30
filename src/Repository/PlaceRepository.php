<?php

namespace App\Repository;

use App\Entity\Place;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Place|null find($id, $lockMode = null, $lockVersion = null)
 * @method Place|null findOneBy(array $criteria, array $orderBy = null)
 * @method Place[]    findAll()
 * @method Place[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Place::class);
    }

    // /**
    //  * @return Place[] Returns an array of Place objects
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
    public function findOneBySomeField($value): ?Place
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    //? querry bulider for method browsePlacebyOneProductCategory()
    /**
     * search for a place by Product Category on entity ProductCategory and  PostalCode on entity Department
     *
     * @param [Int] $productCategoryId
     * @param [String] $postalcode
     * @return void
     */

    public function findByProductCategoryAndPostalcode($productCategoryIds,$postalcode)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.productCategories', 'pc')
            ->innerJoin('p.department' ,'d')
            // Dont forget add  @Groups on entity if decomment
            //->innerJoin('p.reviews', 'r')
            ->Where('pc.id = :id')
            ->andWhere('d.postalcode = :postalcode')
            ->setParameter('id', $productCategoryIds)
            ->setParameter('postalcode', $postalcode)
            ->getQuery()
            ->getResult()
        ;
    }
    //? querry bulider for method browsePlacebyManyProductCategory()
    /**
     * search for a place by Many id Product Category on entity ProductCategory and  PostalCode on entity Department
     *
     * @param [Int] $ids
     * @param [String] $postalcode
     * @return void
     */

    public function findByProductCategory($ids,$postalcode)
    {

        return $this->createQueryBuilder('p')
            ->innerJoin('p.productCategories', 'pc')
            ->innerJoin('p.department' ,'d')
            ->Where('pc.id IN (:id)')
            ->andWhere('d.postalcode = :postalcode')
            ->setParameter('id',$ids)
            ->setParameter('postalcode', $postalcode)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}