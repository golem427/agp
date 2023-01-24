<?php

namespace App\Controller;

use App\Entity\Realisation;
use App\Repository\RealisationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RealisationsController extends AbstractController
{
    #[Route('/realisations', name: 'realisations')]
    public function realisations(
        RealisationRepository $realisationRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
        $data = $realisationRepository->findAll();
        $realisations = $paginator->paginate($data, $request->query->getInt('page', 1));

        return $this->render('realisations/realisations.html.twig',[
        'realisations' => $realisations ]);
    }
}