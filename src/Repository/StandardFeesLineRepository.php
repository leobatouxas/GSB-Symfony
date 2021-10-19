<?php

namespace App\Repository;

use App\Entity\StandardFeesLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StandardFeesLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method StandardFeesLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method StandardFeesLine[]    findAll()
 * @method StandardFeesLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StandardFeesLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StandardFeesLine::class);
    }

    // /**
    //  * @return StandardFeesLine[] Returns an array of StandardFeesLine objects
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
    public function findOneBySomeField($value): ?StandardFeesLine
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
