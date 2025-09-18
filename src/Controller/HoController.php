<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HoController extends AbstractController
{

#[Route(path:'/hi',name:'hi')]
public function hi():Response{

    return new Response('Bonjour mes étudiants');
}







}