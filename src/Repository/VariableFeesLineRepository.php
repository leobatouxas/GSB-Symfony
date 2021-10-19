<?php

namespace App\Repository;

use App\Entity\VariableFeesLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VariableFeesLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method VariableFeesLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method VariableFeesLine[]    findAll()
 * @method VariableFeesLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VariableFeesLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VariableFeesLine::class);
    }

    // /**
    //  * @return VariableFeesLine[] Returns an array of VariableFeesLine objects
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
    public function findOneBySomeField($value): ?VariableFeesLine
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
