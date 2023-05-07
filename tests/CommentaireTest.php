<?php

namespace App\Tests;

use App\Entity\Commentaire;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CommentaireTest extends TestCase
{
    public function testSIsTrue()
    {
        $commentaire=new Commentaire();
        $date = new DateTimeImmutable();

        $commentaire->setAuteur('Auteur')
                    ->setContenu('Contenu')
                    ->setCreatedAt($date)
                    ->setIsPublished(true);

        $this->assertTrue($commentaire->getAuteur() === 'Auteur');
        $this->assertTrue($commentaire->getContenu() === 'Contenu');
        $this->assertTrue($commentaire->getCreatedAt() === $date);
        $this->assertTrue($commentaire->IsIsPublished() === true);
    }

    public function testSIsFalse()
    {
        $commentaire = new Commentaire();
        $date = new DateTimeImmutable();

        $commentaire->setAuteur('Auteur')
                    ->setContenu('Contenu')
                    ->setCreatedAt($date)
                    ->setIsPublished(true);

        $this->assertFalse($commentaire->getAuteur() === 'false');
        $this->assertFalse($commentaire->getContenu() === 'false');
        $this->assertFalse($commentaire->getCreatedAt() === new DateTimeImmutable());
        $this->assertFalse($commentaire->IsIsPublished() === false);
    }

    public function testSIsEmpty()
    {
        $commentaire = new Commentaire();
        $date = new DateTimeImmutable();

        $this->assertEmpty($commentaire->getAuteur());
        $this->assertEmpty($commentaire->IsIsPublished());
    }
}
