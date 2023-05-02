<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConceptiondusiteController extends AbstractController
{
    #[Route('/conceptiondusite', name: 'conception')]
    public function index(): Response
    {
        return $this->render('conceptiondusite/conception.html.twig', [
            'controller_name' => 'ConceptiondusiteController',
        ]);
    }
}
