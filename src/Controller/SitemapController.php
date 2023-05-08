<?php

namespace App\Controller;

use App\Entity\Blogpost;
use App\Entity\Commentaire;
use App\Repository\BlogpostRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommentaireRepository;
use App\Repository\ContactRepository;
use App\Repository\RealisationRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
    #[Route('/sitemap', name: 'sitemap', defaults:['_format'=> 'xml'])]
    public function index(
        Request $request,
        BlogpostRepository $blogpostRepository,
        RealisationRepository $realisationRepository,
        )
    {
        $hostname = $request->getSchemeAndHttpHost();
        $urls = []; /// initialisation du tableau vide des urls /////

///////////////////// on joute les URL STATIQUES //////////////////////////////////
        $urls[]= ['loc' => $this->generateUrl('home')];
        $urls[]= ['loc' => $this->generateUrl('mentions_legales')];
        $urls[]= ['loc' => $this->generateUrl('portfolio')];
        $urls[]= ['loc' => $this->generateUrl('app_login')];
        $urls[]= ['loc' => $this->generateUrl('conception')];
        $urls[]= ['loc' => $this->generateUrl('apropos')];
        $urls[]= ['loc' => $this->generateUrl('realisations')];
        $urls[]= ['loc' => $this->generateUrl('actualites')];
        $urls[]= ['loc' => $this->generateUrl('map')];
   
////////////////////// On ajoute les URLS DYNAMIQUES ////////////////////////////////
        foreach($blogpostRepository->findAll() as $blogpost){
            $imagefiles = [
                'loc' =>'uploads/blogposts/'. $blogpost->getImageFile(),
                'title' => $blogpost->getTitre()
            ];

            $urls[] = [
                'loc'=> $this->generateUrl('details_actu',[
                    'slug'=> $blogpost->getSlug()
                ]),
                'image' => $imagefiles,
                'lastmod'=> $blogpost->getUpdatedAt()->format('Y-m-d')
            ];
        }
////////////////////// On ajoute les URLS DYNAMIQUES ////////////////////////////////
        foreach($realisationRepository->findAll() as $realisation){
            $imagefiles = [
                'loc' =>'uploads/realisations/'. $realisation->getImageFile(),
                'title' => $realisation->getNom()
            ];

            $urls[] = [
                'loc'=> $this->generateUrl('details_actu',[
                    'slug'=> $realisation->getSlug()
                ]),
                'image' => $imagefiles,
                'lastmod'=> $realisation->getUpdatedAt()->format('Y-m-d')
            ];
        }

////////// FABRICATION DE LA REPONSE /////////////////////////////////////
            $response = new Response(
            $this->renderView('sitemap/index.html.twig', [
                        'urls'=>$urls,
                        'hostname'=> $hostname
            ]),
            200
        );
///////// AJOUT DES ENTETES HTTP//////////////////////////////////////////////
            $response -> headers->set('Content-type', 'text/xml');

            return $response;
    }
}