<?php

namespace App\Repository;

use App\Entity\Bo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bo>
 */
class BoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bo::class);
    }

    //    /**
    //     * @return Bo[] Returns an array of Bo objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Bo
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
