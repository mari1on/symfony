<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Authorr;

class BookManagerService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * a) Compter le nombre de livres d’un auteur donné
     */
    public function countBooksByAuthor(Authorr $author): int
    {
        return count($author->getBooks());
    }

    /**
     * b) Retourner la liste des auteurs ayant publié plus de 3 livres
     */
    public function bestAuthors(): array
    {
        $query = $this->em->createQuery(
            'SELECT a 
             FROM App\Entity\Authorr a
             JOIN a.books b
             GROUP BY a.id
             HAVING COUNT(b.id) > 3'
        );

        return $query->getResult();
    }
}
