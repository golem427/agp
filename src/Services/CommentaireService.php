<?php

namespace App\Services;

use App\Entity\Commentaire;
use App\Entity\Blogpost;
use App\Entity\Realisation;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class CommentaireService
{

    private $manager;
    private $flash;

    public function __construct(EntityManagerInterface $manager)
    {
         $this->manager = $manager;
    }

    public function persistCommentaire(
        Commentaire $commentaire,
        Realisation $realisation,
        Blogpost $blogpost
        ):void
    {
        $commentaire->setIsPublished(false)
                    ->setBlogpost($blogpost)
                    ->setRealisation($realisation)
                    ->setCreatedAt(new DateTimeImmutable('now'));

        $$this->manager->persist($commentaire);
        $this->manager->flush();
        $this->flash->$flash->add('success', 'Votre message sera visible après modération');
    }
}
