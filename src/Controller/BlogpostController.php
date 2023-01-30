<?php

namespace App\Controller;

use App\Entity\Blogpost;
use App\Repository\BlogpostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogpostController extends AbstractController
{
    #[Route('/actualites', name: 'actualites')]
    public function actualites(
        
        BlogpostRepository $blogpostRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
        $data = $blogpostRepository->findAll();
        $blogposts = $paginator->paginate($data, $request->query->getInt('page', 1),6); 
        //Le "paginate demande un "integer" pour les n° d 'page', qui démarre à 1 et limite à 6 les résultats par page.

        return $this->render('actualites/actualites.html.twig',[
        'blogposts' => $blogposts ]);
    }


    #[Route('/actualites/{slug}', name: 'details_actualites')]
    public function detailblogpost(Blogpost $blogpost): Response
    {
        return $this->render('actualites/detailsactualites.html.twig', [
            'blogpost' => $blogpost
        ]);
    }

}