<?php

namespace App\Controller;

use App\Repository\BlogpostRepository;
use App\Repository\RealisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function home(RealisationRepository $RealisationRepository, BlogpostRepository $blogpostRepository): Response
    {
        return $this->render(
            'home.html.twig',
            ['realisations' => $RealisationRepository->last(),
            'blogposts' => $blogpostRepository->last()]
        );
    }
}