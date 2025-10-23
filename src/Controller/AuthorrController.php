<?php

namespace App\Controller;

use App\Repository\AuthorrRepository;  
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Authorr;
use App\Form\AuthorrType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Book;
use App\Form\BookType;
use App\Entity\Reader;
use App\Form\ReaderType;
use App\Repository\BookRepository;



final class AuthorrController extends AbstractController
{
    #[Route('/authorr', name: 'app_authorr')]
    public function index(): Response
    {
        return $this->render('authorr/index.html.twig', [
            'controller_name' => 'AuthorrController',
        ]);
    }




    /*
   #[Route('/showall', name: 'showall')]
public function showall(AuthorrRepository $repo, ManagerRegistry $doctrine): Response
{
    // Get all authors
    $authorrs = $repo->findAll();

    // Get the Book repository and fetch all books
    $bookRepo = $doctrine->getRepository(Book::class);
    $books = $bookRepo->findAll(); // ✅ now $books is defined
$readers = $doctrine->getRepository(Reader::class)->findAll();
    return $this->render('author/showall.html.twig', [
        'list' => $authorrs,
        'listbook' => $books,
        'listreader' => $readers,
    ]);
}*/


#[Route('/showall', name: 'showall')]
public function showall(Request $request, AuthorrRepository $repo, ManagerRegistry $doctrine, BookRepository $bookRepository): Response
{
    // Tous les auteurs
    $authorrs = $repo->findAll() ?? [];

    // Tous les lecteurs
    $readers = $doctrine->getRepository(Reader::class)->findAll() ?? [];

    // Recherche par ID pour les livres
    $id = $request->query->get('id');

    if ($id) {
        $books = [];
        $book = $bookRepository->searchBookByRef((int) $id);
        if ($book) {
            $books[] = $book;
        }
    } else {
        $books = $bookRepository->findAll() ?? [];
    }

    // On renvoie toujours les 3 listes
    return $this->render('author/showall.html.twig', [
        'list' => $authorrs,       // auteurs
        'listbook' => $books,      // livres
        'listreader' => $readers,  // lecteurs
    ]);
}




    #[Route('/add', name: 'add')]
    public function add(ManagerRegistry $doctrine): Response
    {
        $authorr = new Authorr();
        $authorr->setEmail('newemail@esprit.tn');
        $authorr->setUsername('New Name');

        $em = $doctrine->getManager();
        $em->persist($authorr);
        $em->flush();

        return $this->redirectToRoute('showall'); 
    }

    #[Route('/deleteAuthor/{id}', name: 'deleteAuthor')]
    public function deleteAuthor($id, AuthorrRepository $repo, ManagerRegistry $doctrine): Response
    {
        $authorr = $repo->find($id);

        if (!$authorr) {
            throw $this->createNotFoundException('Author not found with id ' . $id);
        }

        $em = $doctrine->getManager();
        $em->remove($authorr);
        $em->flush();

        return $this->redirectToRoute('showall');
    }

    #[Route('/showDetails/{id}', name: 'showDetails')]
    public function showDetails($id, AuthorrRepository $repo): Response
    {
        $authorr = $repo->find($id);

        if (!$authorr) {
            throw $this->createNotFoundException('Author not found with id ' . $id);
        }

        return $this->render('author/showDetails.html.twig', [
            'authorr' => $authorr,
        ]);
    }


#[Route('/updateAuthor/{id}', name: 'updateAuthor')]        
public function updateAuthor($id, AuthorrRepository $repo, Request $request, ManagerRegistry $doctrine): Response
{
    $authorr = $repo->find($id);

    if (!$authorr) {
        throw $this->createNotFoundException('Author not found with id ' . $id);
    }

    $form = $this->createForm(AuthorrType::class, $authorr);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();
        $em->flush();

        return $this->redirectToRoute('showall');
    }

    return $this->render('author/updateAuthor.html.twig', [
        'form' => $form->createView(),
    ]);

}


#[Route('/addform', name: 'addform')]
public function addform(Request $request, ManagerRegistry $doctrine ): Response
{
    $author = new Authorr();
    $form = $this->createForm(AuthorrType::class, $author);

    // Gérer la soumission du formulaire
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // Sauvegarder les données dans la base
        $em = $doctrine->getManager(); 
        $em->persist($author);
        $em->flush();

        // Rediriger ou afficher un message
        return $this->redirectToRoute('addform'); // ou une autre route
    }

    return $this->render('author/addform.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('/Readerform', name: 'Readerform')]
public function Readerform(Request $request, ManagerRegistry $doctrine): Response
{
    $reader = new Reader();
    $form = $this->createForm(ReaderType::class, $reader);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();
        $em->persist($reader);
        $em->flush();

        return $this->redirectToRoute('showall'); // ou une autre route
    }

    return $this->render('author/Readerform.html.twig', [
        'form' => $form->createView(),
    ]);
}


#[Route('/addreader', name: 'addreader')]
public function addreader(Request $request, ManagerRegistry $doctrine ): Response
{


    $reader = new Reader();
    $form = $this->createForm(ReaderType::class, $reader);
    // Gérer la soumission du formulaire
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // Sauvegarder les données dans la base
        $em = $doctrine->getManager();


        $em->persist($reader);  
        $em->flush();   



        // Rediriger ou afficher un message
        return $this->redirectToRoute('showall'); // ou une autre route
    }

    return $this->render('author/Readerform.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/updateReader/{id}', name: 'updateReader')]
public function updateReader($id, Request $request, ManagerRegistry $doctrine): Response
{
    $reader = $doctrine->getRepository(Reader::class)->find($id);                   
    if (!$reader) {
        throw $this->createNotFoundException('Reader not found with id ' . $id);
    }               
    $form = $this->createForm(ReaderType::class, $reader);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();
        $em->flush();

        return $this->redirectToRoute('showall');
    }

    return $this->render('author/updateReader.html.twig', [
        'form' => $form->createView(),
    ]); 



}
#[Route('/deleteReader/{id}', name: 'deleteReader')]
        


public function deleteReader($id, ManagerRegistry $doctrine): Response
{
    $reader = $doctrine->getRepository(Reader::class)->find($id);

    if (!$reader) {
        throw $this->createNotFoundException('Reader not found with id ' . $id);
    }

    $em = $doctrine->getManager();
    $em->remove($reader);
    $em->flush();

    return $this->redirectToRoute('showall');               
    
}


#[Route('/showReaderDetails/{id}', name: 'showReaderDetails')]
public function showReaderDetails($id, ManagerRegistry $doctrine): Response
{
    $reader = $doctrine->getRepository(Reader::class)->find($id);   
    if (!$reader) {
        throw $this->createNotFoundException('Reader not found with id ' . $id);
    }
    return $this->render('author/showReaderDetails.html.twig', [
        'reader' => $reader,
    ]);





}
#[Route('/showallAuthors', name: 'showallAuthors')]


public function showallAuthors(AuthorrRepository $repo, ManagerRegistry $doctrine): Response
{
    $authorrs= $repo->showAllAuthors();
       $bookRepo = $doctrine->getRepository(Book::class);
    $books = $bookRepo->findAll(); // ✅ now $books is defined
$readers = $doctrine->getRepository(Reader::class)->findAll();
    return $this->render('author/showall.html.twig', [
        'list' => $authorrs,
         'listbook' => $books,
        'listreader' => $readers,
       
    ]);
}
 #[Route('/ListAuthorsByEmail', name: 'ListAuthorsByEmail')]
    public function listAuthorByEmail(AuthorrRepository $repo): Response
    {
        $authors = $repo->listAuthorByEmail(); // call the repository method

        return $this->render('author/show_by_email.html.twig', [
            'authors' => $authors,
        ]);
    }

     #[Route('/books_between_dates', name: 'books_between_dates')]
public function booksBetweenDates(BookRepository $bookRepository): Response
{
    $startDate = new \DateTime('2014-01-01');
    $endDate = new \DateTime('2018-12-31');
    $books = $bookRepository->findBooksBetweenDates($startDate, $endDate);

    return $this->render('author/showall.html.twig', [
        'listbook' => $books,
    ]);
}


}