<?php

namespace App\Services;

use App\Entity\Commentaire;
use App\Entity\Blogpost;
use App\Entity\Realisation;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class CommentaireService
{
    private $em;
    // private $flash;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function persistCommentaire(
        Commentaire $commentaire,
        Realisation $realisation = null,
        Blogpost $blogpost = null
    ): void {
        $commentaire->setIsPublished(false)
                    ->setRealisation($realisation)
                    ->setBlogpost($blogpost)
                    ->setCreatedAt(new DateTimeImmutable('now'));

        $$this->em->persist($commentaire);
        $this->em->flush();
        // $this->flash->$flash->add('success', 'Votre message sera visible après modération');
    }
  
}
