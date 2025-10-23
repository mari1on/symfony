<?php

namespace App\Repository;

use App\Entity\Authorr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Authorr>
 */
class AuthorrRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Authorr::class);
    }

    //    /**
    //     * @return Authorr[] Returns an array of Authorr objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Authorr
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function showAllAuthors()
    {
  return $this->createQueryBuilder('a')
  ->orderBy('a.username', 'ASC')
            ->andWhere('a.email LIKE :condition')
            ->setParameter('condition', 'LIKE %a%')

            ->getQuery()
            ->getResult();
    }

public function listAuthorByEmail()
    {
        return $this->createQueryBuilder('a')
            ->select('a', 'COUNT(b.id) AS numBooks')
            ->leftJoin('a.books', 'b') // suppose que relation OneToMany : Authorr -> Book
            ->groupBy('a.id')
            ->orderBy('a.email', 'ASC')
            ->getQuery()
            ->getResult();
    }

    
public function searchBookByRef(int $id): ?Book
{
    return $this->createQueryBuilder('b')
        ->andWhere('b.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getOneOrNullResult();
}



public function findAuthorsWithMoreThan10Books(): array
{
    return $this->createQueryBuilder('a')
        ->join('a.books', 'b')
        ->groupBy('a.id')
        ->having('COUNT(b.id) > 10')
        ->getQuery()
        ->getResult();
}

}

