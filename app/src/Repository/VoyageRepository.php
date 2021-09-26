<?php

namespace App\Repository;

use App\Entity\Voyage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

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
    
    public function findVoyagesByActivityId(int $id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM `voyage_activite` INNER JOIN  voyage ON voyage_activite.voyage_id = voyage.id
        WHERE  activite_id = :activiteId';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['activiteId' => $id]);

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

    public function findVoyagesBySaisonId(int $saisonId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM `voyage_saison` INNER JOIN  voyage ON voyage_saison.voyage_id = voyage.id
        WHERE  saison_id = :saisonId';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['saisonId' => $saisonId]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }

    // Find/search voyages by name
    public function findVoyagesByName(string $query)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where(
                $qb->expr()->like('p.name', ':query')
            )
            ->setParameter('query', '%' . $query . '%')
        ;
        return $qb
            ->getQuery()
            ->getResult();
    }

    // Find/search voyages by date depart
    public function findVoyagesByDateDepart(string $depart)
    {
        $qb = $this->createQueryBuilder('v')
        ->join('v.infoPratique', 'ip')
        ->where('ip.depart LIKE :depart')
        ->setParameter('depart', $depart . "%");

        $result = $qb->getQuery()->getResult();

        return $result;
    }
}
