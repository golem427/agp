<?php

namespace App\Controller;

use App\Repository\RealisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function homeController(): Response
    {
        return $this->render('home.html.twig')
        ;
}

// ['controller_name'=>'HomeController'])

//['realisations'=> $realisationRepository->lastTen()])
}