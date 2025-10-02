<?php

namespace App\Controller;
use App\Repository\AuthorrRepository;  
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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

}
