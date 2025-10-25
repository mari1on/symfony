<?php
// src/Controller/BookController.php
namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\BookManagerService;

use App\Repository\BookRepository;

class BookController extends AbstractController
{
    #[Route('/book/new', name: 'book_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save to database
            $em->persist($book);
            $em->flush();

            $this->addFlash('success', 'Book saved successfully!');

            return $this->redirectToRoute('book_new'); // or any page
        }

        return $this->render('book/addform.html.twig', [
            'form' => $form->createView(),
        ]);
    }

#[Route('/bookform', name: 'bookform')]
public function bookform(Request $request, ManagerRegistry $doctrine): Response
{
    $book = new Book();
    $form = $this->createForm(BookType::class, $book);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();
        $em->persist($book);
        $em->flush();

        return $this->redirectToRoute('showall'); // ou une autre route
    }

    return $this->render('author/bookform.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('/deleteBook/{id}', name: 'deleteBook')]
public function deleteBook($id, ManagerRegistry $doctrine): Response
{
    $book = $doctrine->getRepository(Book::class)->find($id);

    if (!$book) {
        throw $this->createNotFoundException('Book not found with id ' . $id);
    }

    $em = $doctrine->getManager();
    $em->remove($book);
    $em->flush();

    return $this->redirectToRoute('showall');               

}

#[Route('/updateBook/{id}', name: 'updateBook')]        
public function updateBook($id, Request $request, ManagerRegistry $doctrine): Response
{
    $book = $doctrine->getRepository(Book::class)->find($id);                   
    if (!$book) {
        throw $this->createNotFoundException('Book not found with id ' . $id);
    }               
    $form = $this->createForm(BookType::class, $book);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();
        $em->flush();

        return $this->redirectToRoute('showall');
    }

    return $this->render('author/updateBook.html.twig', [
        'form' => $form->createView(),
    ]);
}



#[Route('/showBookDetails/{id}', name: 'showBookDetails')]
public function showBookDetails($id, ManagerRegistry $doctrine): Response
{
    $book = $doctrine->getRepository(Book::class)->find($id);

    if (!$book) {
        throw $this->createNotFoundException('Book not found with id ' . $id);
    }

    return $this->render('author/showBookDetails.html.twig', [
        'book' => $book,
    ]);
}

#[Route('/books', name: 'app_books')]
public function index(Request $request, BookRepository $bookRepository): Response
{
    $ref = $request->query->get('ref');
    if ($ref) {
        $book = $bookRepository->searchBookByRef($ref);
        $books = $book ? [$book] : [];
    } else {
        $books = $bookRepository->findAll();
    }

    return $this->render('authorr/index.html.twig', [
        'books' => $books,
        'ref' => $ref,
    ]);
}
#[Route('/booksByAuthors', name: 'books_by_authors')]
public function booksByAuthors(BookRepository $bookRepository): Response
{
    $books = $bookRepository->booksListByAuthors();

    return $this->render('author/showall.html.twig', [
        'listbook' => $books,
        'list' => [],        // si tu veux juste afficher les livres
        'listreader' => [],  // tu peux ajouter les lecteurs si nécessaire
    ]);
}


#[Route('/books-special', name: 'books_special')]
public function booksSpecial(BookRepository $bookRepository): Response
{
    $books = $bookRepository->findBooksBefore2023WithAuthorHavingMoreThan10Books();

    return $this->render('author/showall.html.twig', [
        'listbook' => $books,
        'list' => [],         // si tu veux juste afficher les livres
        'listreader' => [],   // ou ajouter les lecteurs si nécessaire
    ]);
}
#[Route('/findbooksBetweenDates', name: 'findBooksBetweenDates')]
public function findBooksBetweenDates(Request $request, BookRepository $bookRepository): Response
{
    // Get dates from request query (e.g., ?start=2023-01-01&end=2023-12-31)
    $startDate = new \DateTime($request->query->get('start'));
    $endDate = new \DateTime($request->query->get('end'));

    // Use the repository method
    $books = $bookRepository->findBooksBetweenDates($startDate, $endDate);

    return $this->render('author/showall.html.twig', [
        'listbook' => $books,
        'list' => [],
        'listreader' => [],
    ]);

}
#[Route('/books/entre', name: 'books_entre')]
public function livresEntreDates(BookRepository $repo)
{
    $dateDebut = new \DateTime('2014-01-01');
    $dateFin = new \DateTime('2018-12-31');

    $books = $repo->findLivresEntreDates($dateDebut, $dateFin);

    return $this->render('book/liste.html.twig', [
        'books' => $books,
    ]);
}

 #[Route('/best-authors', name: 'best_authors')]
    public function bestAuthors(BookManagerService $bookManagerService): Response
    {
        $authors = $bookManagerService->bestAuthors();

        if (empty($authors)) {
            return new Response("Aucun auteur avec plus de 3 livres trouvé 😢");
        }

        $output = "Auteurs avec plus de 3 livres : <br>";
        foreach ($authors as $author) {
            $output .= "- " . $author->getName() . "<br>";
        }

        return new Response($output);
    }





}
