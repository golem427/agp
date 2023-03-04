<?php

namespace App\Controller;

use App\Entity\Blogpost;
use App\Entity\Commentaire;
use App\Entity\Realisation;
use App\Repository\BlogpostRepository;
use App\Repository\CommentaireRepository;
use App\Repository\RealisationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;

class CommentaireController extends AbstractController
{
    #[Route('/commentaires', name: 'commentaires')]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
    return $this->render('commentaires/commentaires.html.twig', 
        [
        'commentaires' => $commentaireRepository->findBy([], ['id'=>'DESC'])
        ]); 
    }
}
