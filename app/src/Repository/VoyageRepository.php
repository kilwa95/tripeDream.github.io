<?php

namespace App\Repository;

use App\Entity\Voyage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Voyage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voyage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voyage[]    findAll()
 * @method Voyage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoyageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voyage::class);
    }

    // /**
    //  * @return Voyage[] Returns an array of Voyage objects
    //  */
    
    public function findVoyagesByActivityId(int $activiteId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM `voyage_activite` INNER JOIN  voyage ON voyage_activite.voyage_id = voyage.id
        WHERE  activite_id = :activiteId';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['activiteId' => $activiteId]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }

    public function findVoyagesByPaysId(int $paysId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM `voyage_pays` INNER JOIN  voyage ON voyage_pays.voyage_id = voyage.id
        WHERE  pays_id = :paysId';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['paysId' => $paysId]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }
}
