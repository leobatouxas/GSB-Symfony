<?php

namespace App\Repository;

use App\Entity\FeeSheet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FeeSheet|null find($id, $lockMode = null, $lockVersion = null)
 * @method FeeSheet|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeeSheet[]    findAll()
 * @method FeeSheet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeeSheetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeeSheet::class);
    }

    // /**
    //  * @return FeeSheet[] Returns an array of FeeSheet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FeeSheet
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
