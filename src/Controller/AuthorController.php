<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }


 #[Route('/show/{name}', name: 'showauthor')]
public function showAuthor(string $name): Response
{
    return $this->render('author/show.html.twig', [
        'nom' => $name
    ]);
}


 #[Route('/list', name: 'listAuthors')]
public function listAuthors(): Response
{
    $authors = array(
array('id' => 1, 'picture' => 'assets/images/1.jpeg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
array('id' => 2, 'picture' => 'assets/images/2.jpeg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
array('id' => 3, 'picture' => 'assets/images/3.jpeg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
);

 return $this->render('author/listt.html.twig', [
        'authors' => $authors
    ]);


}






}