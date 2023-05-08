<?php

namespace App\Controller;

use App\Entity\Blogpost;
use App\Entity\Realisation;
use Symfony\Component\HttpKernel\UriSigner;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
    #[Route('/sitemap', name: 'sitemap', priority: 1)]
    public function sitemap(): Response
    {        return $this->render('sitemap/sitemap.html.twig', [
            'controller_name' => 'SitemapController',
        ]);
    }

    public function xmlAction(): Response
    {
        return BinaryFileResponse::create(
            $this->getParameter('kernel.project_dir') . '/config/routes/application/xml.xml'
        );
    }

    public function yamlAction(): Response
    {
        return BinaryFileResponse::create(
            $this->getParameter('kernel.project_dir') . '/config/routes/application/yaml.yaml'
        );
    }



    #[Route('/realisations/{slug}', name: 'real_details')]
    public function RealisationAction(Realisation $realisation): Response
    {
        return $this->render('realisations/realisationsdetails.html.twig', ['realisation' => $realisation]);
    }

    #[Route('/actualites/{slug}', name: 'details_actu')]
    public function blogpostAction(BlogPost $blogpost): Response
    {
        return $this->render('actualites/detailsactualites.html.twig', ['blogpost' => $blogpost]);
    }
}



/** Yann Eugoné <yeugone@prestaconcept.net>
 */
// class DefaultController extends AbstractController
// {
    /**
     * @Route("/", name="homepage", options={"sitemap" = {"priority":1}})
     */
    // public function indexAction(): Response
    // {
    //     return $this->render('default/index.html.twig', []);
    // }

    // public function xmlAction(): Response
    // {
    //     return BinaryFileResponse::create(
    //         $this->getParameter('kernel.project_dir') . '/config/routes/application/xml.xml'
    //     );
    // }

    // public function yamlAction(): Response
    // {
    //     return BinaryFileResponse::create(
    //         $this->getParameter('kernel.project_dir') . '/config/routes/application/yaml.yaml'
    //     );
    // }

    /**
     * @Route("/{slug}", name="page")
     */
    // public function pageAction(Page $page): Response
    // {
    //     return $this->render('default/page.html.twig', ['page' => $page]);
    // }

    /**
     * @Route("/blog/{slug}", name="blog")
     */
//     public function blogAction(BlogPost $post): Response
//     {
//         return $this->render('default/blog.html.twig', ['post' => $post]);
//     }
// }

// #[Route('/sitemap', name: 'sitemap', defaults: ['_format' => 'xml'], priority: 1)]
// public function sitemap(Request $request, UriSigner $uriSigner): Response
// {   
//     if (!$uriSigner->checkRequest($request)) {
//                 return $this->render('sitemap/sitemap.xml.twig', [
//         'controller_name' => 'SitemapController',
//     ]);
//     }
// }