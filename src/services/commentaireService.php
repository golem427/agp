<?php

namespace App\Service;

use DateTime;
use App\entity\Blogpost;
use App\entity\Commentaire;
use App\entity\Realisation;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class CommentaireService
{
    private $manager;
    private $flash;
    
    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flash)
    {
        $this->manager = $manager;
        $this->flash = $flash;
    }

    public function persistCommentaire(
        Commentaire $commentaire,
        Blogpost $blogpost = null,
        Realisation $realisation = null,
    ):void
    {
        $commentaire->setIsPublished(false)
                    ->setBlogpost($blogpost)
                    ->setRealisation($realisation)
                    ->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($commentaire);
        $this->manager->flush();
        $this->flash->add('success', 'Votre commentaire a bien été envoyé, il sera publié après modération.');
            
    }
}















?>