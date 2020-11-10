<?php

namespace App\Repository;

use App\Entity\InfoPratique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InfoPratique|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoPratique|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoPratique[]    findAll()
 * @method InfoPratique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoPratiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoPratique::class);
    }

    // /**
    //  * @return InfoPratique[] Returns an array of InfoPratique objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InfoPratique
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
