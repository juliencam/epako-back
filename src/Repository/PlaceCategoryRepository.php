<?php

namespace App\Repository;

use App\Entity\PlaceCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlaceCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlaceCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlaceCategory[]    findAll()
 * @method PlaceCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlaceCategory::class);
    }

}
