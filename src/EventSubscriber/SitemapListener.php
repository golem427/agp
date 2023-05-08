<?php

namespace App\Listener;

use App\Entity\BlogPost;
use App\Entity\Realisation;
use Doctrine\ORM\EntityManagerInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author Yann Eugoné <yeugone@prestaconcept.net>
 */
class SitemapListener implements EventSubscriberInterface
{
    private EntityManagerInterface $doctrine;

    private UrlGeneratorInterface $router;

    public function __construct(EntityManagerInterface $doctrine, UrlGeneratorInterface $router)
    {
        $this->doctrine = $doctrine;
        $this->router = $router;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SitemapPopulateEvent::class => 'populateSitemap',
        ];
    }

    public function populateSitemap(SitemapPopulateEvent $event): void
    {
        if (\in_array($event->getSection(), ['realisation', null], true)) {
            $this->registerRealisations($event->getUrlContainer());
        }
        if (\in_array($event->getSection(), ['blogpost', null], true)) {
            $this->registerBlogPosts($event->getUrlContainer());
        }
    }

    private function registerRealisations(UrlContainerInterface $urlContainer): void
    {
        $realisations = $this->doctrine->getRepository(Realisation::class)->findAll();

        /** @var Realisation $realisation */
        foreach ($realisations as $realisation) {
            $urlContainer->addUrl(
                $this->url(
                    'realisations',
                    ['slug' => $realisation->getSlug()],
                ),
                'real_details'
            );
        }
    }

    private function registerBlogPosts(UrlContainerInterface $urlContainer): void
    {
        $blogposts = $this->doctrine->getRepository(BlogPost::class)->findAll();

        /** @var BlogPost $blogpost */
        foreach ($blogposts as $blogpost) {
            $urlContainer->addUrl(
                $this->url(
                    'blogspot',
                    ['slug' => $blogpost->getSlug()],
                ),
                'details_actu'
            );
        }
    }

    function url(string $route, array $parameters = []): UrlConcrete
    {
        return new UrlConcrete(
            $this->router->generate($route, $parameters, RouterInterface::ABSOLUTE_URL)
        );
    }
}
