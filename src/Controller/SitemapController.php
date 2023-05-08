<?php

namespace App\Controller;

use App\Repository\BlogpostRepository;
use App\Repository\RealisationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
    #[Route('/sitemap.xml', name: 'sitemap')]
    public function indexBlogpost(BlogpostRepository $blogpostRepository)
    {
        // find published blog posts from db
        $blogposts = $blogpostRepository->findAll();
        $urls = [];
        foreach ($blogposts as $blogpost) {
            $urls[] = [
                'loc' => $this->generateUrl(
                    'blogpost',
                    ['slug' => $blogpost->getSlug()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'lastmod' => $blogpost->getUpdatedAt()->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ];
        }
        $response = new Response(
            $this->renderView('./sitemap/sitemap.html.twig', ['urls' => $urls]),
            200
        );
        $response->headers->set('Content-Type', 'text/xml');
        return $response;
    }
    
    public function indexRealisation(RealisationRepository $realisationRepository)
    {
        // find published blog posts from db
        $realisations = $realisationRepository->findAll();
        $urls = [];
        foreach ($realisations as $realisation) {
            $urls[] = [
                'loc' => $this->generateUrl(
                    'blogpost',
                    ['slug' => $realisation->getSlug()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                'lastmod' => $realisation->getUpdatedAt()->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ];
        }
        $response = new Response(
            $this->renderView('./sitemap/sitemap.html.twig', ['urls' => $urls]),
            200
        );
        $response->headers->set('Content-Type', 'text/xml');
        return $response;
    }
}