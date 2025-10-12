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
}
