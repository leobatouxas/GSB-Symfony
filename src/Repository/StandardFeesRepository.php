<?php

namespace App\Repository;

use App\Entity\StandardFees;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StandardFees|null find($id, $lockMode = null, $lockVersion = null)
 * @method StandardFees|null findOneBy(array $criteria, array $orderBy = null)
 * @method StandardFees[]    findAll()
 * @method StandardFees[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StandardFeesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StandardFees::class);
    }

    // /**
    //  * @return StandardFees[] Returns an array of StandardFees objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StandardFees
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
