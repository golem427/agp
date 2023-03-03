<?php

namespace App\Controller;

use App\Entity\Blogpost;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\BlogpostRepository;
use App\Repository\CommentaireRepository;
use App\Service\CommentaireService;
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
        $data = $blogpostRepository->findBy([], ['id'=>'DESC'] );
        
        $blogposts = $paginator->paginate($data, $request->query->getInt('page', 1),6); 
        //Le "paginate demande un "integer" pour les n° d 'page', qui démarre à 1 et limite à 6 les résultats par page.

        return $this->render('actualites/actualites.html.twig',[
        'blogposts' => $blogposts ]);
    }


    #[Route('/actualites/{slug}', name: 'details_actu')]
    public function blogpost(
        Blogpost $blogpost,
        Commentaire $commentaire,
        CommentaireService $commentaireService,
        CommentaireRepository $commentaireRepository,
        Request $request
        ): Response
    {   
        $commentaire = new Commentaire();
        $commentaires = $commentaireRepository->findCommentaire($blogpost);

        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $commentaire = $form->getData();
            $commentaireService->persistCommentaire($commentaire, $blogpost, null);

            return $this->redirectToRoute('details_actu', ['slug' => $blogpost->getSlug()]);
        }
            return $this->render('actualites/detailsactualites.html.twig',
            [
                'blogpost' => $blogpost,
                'form' => $form->createView(),
                'commentaires' => $commentaires,
            ]);
        
    }
}
