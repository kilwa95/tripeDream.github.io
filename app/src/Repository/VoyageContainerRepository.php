<?php

namespace App\Repository;

use App\Entity\VoyageContainer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VoyageContainer|null find($id, $lockMode = null, $lockVersion = null)
 * @method VoyageContainer|null findOneBy(array $criteria, array $orderBy = null)
 * @method VoyageContainer[]    findAll()
 * @method VoyageContainer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoyageContainerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VoyageContainer::class);
    }

    // /**
    //  * @return VoyageContainer[] Returns an array of VoyageContainer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VoyageContainer
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
