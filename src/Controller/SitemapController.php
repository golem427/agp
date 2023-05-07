<?php

namespace App\Controller;

use Symfony\Component\HttpKernel\UriSigner;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
    #[Route('/sitemap', name: 'sitemap', defaults: ['_format' => 'xml'])]
    public function smap(Request $request, UriSigner $uriSigner): Response
    {   
        if (!$uriSigner->checkRequest($request)) {
                    return $this->render('sitemap/sitemap.xml.twig', [
            'controller_name' => 'SitemapController',
        ]);
    }
    }
}
