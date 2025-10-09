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


final class AuthorrController extends AbstractController
{
    #[Route('/authorr', name: 'app_authorr')]
    public function index(): Response
    {
        return $this->render('authorr/index.html.twig', [
            'controller_name' => 'AuthorrController',
        ]);
    }

    #[Route('/showall', name: 'showall')]
    public function showall(AuthorrRepository $repo): Response
    {
        $authorrs = $repo->findAll();

        return $this->render('author/showall.html.twig', [
            'list' => $authorrs,
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


}
