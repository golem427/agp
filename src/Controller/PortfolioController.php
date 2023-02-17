<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\RealisationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PortfolioController extends AbstractController
{
    #[Route('/portfolio', name: 'portfolio')]
    public function portfolio(CategorieRepository $categorieRepository): Response
    {
        return $this->render('portfolio/portfolio.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/portfolio/{slug}', name: 'portfolio_slug')]
    public function categorie(Categorie $categorie, RealisationRepository $realisationRepository)
    :Response
    {
        $realisations = $realisationRepository->findAllPortfolio($categorie);

        return $this->render('portfolio/categorie.html.twig',
        [
            'categorie' => $categorie,
            'realisations' => $realisations,
        ]);
    }
}