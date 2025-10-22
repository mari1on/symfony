<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;




use App\Entity\Bo;
use App\Form\BoformType; // also make sure this is added

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry; // also make sure this is added for $doctrine

final class BoController extends AbstractController
{
    #[Route('/bo', name: 'app_bo')]
    public function index(): Response
    {
        return $this->render('bo/index.html.twig', [
            'controller_name' => 'BoController',
        ]);
    }



    #[Route('/backoffice', name: 'backoffice')]
    public function backoffice(): Response
    {
        return $this->render('author/backoffice.html.twig', [
            'controller_name' => 'BoController',
        ]);
}

#[Route('/form', name: 'form')]
public function form(Request $request, ManagerRegistry $doctrine): Response
{
    $bo = new Bo();
    $form = $this->createForm(BoformType::class, $bo);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();
        $em->persist($bo);
        $em->flush();

        $this->addFlash('success', 'Formulaire saved successfully!');
        return $this->redirectToRoute('form'); // redirect to same page or another page
    }

    return $this->render('author/form.html.twig', [
        'form' => $form->createView(),
    ]);
}

}