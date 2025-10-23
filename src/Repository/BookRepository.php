<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
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

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


public function booksListByAuthors(): array
{
    // On utilise QueryBuilder pour créer la requête
    return $this->createQueryBuilder('b')  // 'b' est l'alias pour Book
        ->join('b.authorr', 'a')           // on fait la jointure avec l'auteur
        ->addSelect('a')                   // sélectionner aussi l'auteur
        ->orderBy('a.username', 'ASC')     // trier par nom d'auteur (ou email si tu veux)
        ->getQuery()
        ->getResult();                     // retourne le tableau d'objets Book
}

public function findBooksBefore2023WithAuthorHavingMoreThan10Books()
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.authorr', 'a')
            ->groupBy('a.id')
            ->having('COUNT(b.id) > 10')
            ->andWhere('b.publicationDate < :date')
            ->setParameter('date', new \DateTime('2023-01-01'))
            ->getQuery()
            ->getResult();
    }
// src/Repository/BookRepository.php
public function searchBookByRef(int $ref): ?Book
{
    return $this->createQueryBuilder('b')
                ->andWhere('b.id = :ref') // or change 'id' to your 'ref' field
                ->setParameter('ref', $ref)
                ->getQuery()
                ->getOneOrNullResult();
}

}
