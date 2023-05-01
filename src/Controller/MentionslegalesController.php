<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MentionslegalesController extends AbstractController
{
    #[Route('/mentionslegales', name: 'mentions_legales')]
    public function index(): Response
    {
        return $this->render('mentionslegales/mentions_legales.html.twig', [
            'controller_name' => 'MentionslegalesController',
        ]);
    }
}
