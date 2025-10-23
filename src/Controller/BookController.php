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
#[Route('/books', name: 'app_books')]
public function showAll(Request $request, BookRepository $bookRepository): Response
{
    $id = $request->query->get('id');

    if ($id) {
        $books = [];
        $book = $bookRepository->searchBookByRef((int) $id);
        if ($book) {
            $books[] = $book;
        }
    } else {
        $books = $bookRepository->findAll();
    }

    return $this->render('author/showall.html.twig', [
        'books' => $books,
    ]);
}


}
