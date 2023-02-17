<?php

namespace App\EventSubscriber;

use DateTime;
use App\Entity\Blogpost;
use App\Entity\Realisation;
use DateTimeImmutable;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $security;
    private $slugger;


    public function __construct(Security $security, SluggerInterface $slugger)
    {
        $this->security = $security;
        $this->slugger = $slugger;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setDateAndUser'],
        ];
    }

    public function setDateAndUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (($entity instanceof Blogpost)) {
            return
                [
                    $now = new DateTime('now'),
                    $entity->setCreatedAt($now),
                    $user = $this->security->getUser(),
                    $entity->setUser($user)
                ];


            if (($entity instanceof Realisation)) {
                return
                    [
                        $now = new DateTime('now'),
                        $entity->setCreatedAt($now),
                        $user = $this->security->getUser(),
                        $entity->setUser($user)
                    ];
            }
        }
        return;
    }
}
