<?php

namespace App\Controller;

use App\Entity\Realisation;
use App\Repository\RealisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RealisationsController extends AbstractController
{
    #[Route('/realisations', name: 'realisations')]
    public function realisations(RealisationRepository $realisationRepository): Response
    {
        return $this->render('realisations/realisations.html.twig', [
            'realisations' => $realisationRepository->findAll(),
        ]);
    }
}
