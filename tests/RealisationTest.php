<?php

namespace App\Tests;

use App\Entity\Attachment;
use DateTime;
use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Realisation;
use PHPUnit\Framework\TestCase;

class RealisationTest extends TestCase
{
    public function testIsTrue(): void
    {   
        $realisation = new Realisation();
        $user = new User();

        $date = new DateTimeImmutable();
        $id = $user->getId();

        $realisation->setNom('nom')
                    ->setDescription('description')
                    ->setPortfolio('portfolio')
                    ->setSlug('slug')
                    ->setCreatedAt($date)
                    ->setUser($user);

        $this->assertTrue($realisation->getNom() === 'nom');
        $this->assertTrue($realisation->getDescription() === 'description');
        $this->assertTrue($realisation->isPortfolio() === true );
        $this->assertTrue($realisation->getCreatedAt() === $date);
        $this->assertTrue($realisation->getUser() === $user);
        $this->assertTrue($realisation->getId() === $id);
    }

    public function testIsFalse(): void
    {   
        $realisation = new Realisation();
        $user = new User();

        $date = new DateTimeImmutable();
        $update = new DateTime();

        $realisation->setNom('nom')
                    ->setDescription('description')
                    ->setPortfolio('portfolio')
                    ->setThumbnail('thumbnail')
                    ->setSlug('slug')
                    ->setCreatedAt($date)
                    ->setUser($user);

        $this->assertFalse($realisation->getNom() === 'false');
        $this->assertFalse($realisation->getDescription() === 'false');
        $this->assertFalse($realisation->isPortfolio() === 'false');
        $this->assertFalse($realisation->getThumbnail() === 'false');
        $this->assertFalse($realisation->getSlug() === 'false');
        $this->assertFalse($realisation->getCreatedAt() === new DateTimeImmutable());
        $this->assertFalse($realisation->getUser() === new User());
    }

    public function testIsEmpty(): void
    {   
        $realisation = new Realisation();    

        $this->assertEmpty($realisation->getNom());
        $this->assertEmpty($realisation->getDescription());
        $this->assertEmpty($realisation->isPortfolio());
        $this->assertEmpty($realisation->getThumbnail());
        $this->assertEmpty($realisation->getSlug());
        $this->assertEmpty($realisation->getUser());
        $this->assertEmpty($realisation->getId());
    }

    public function testAddGetRemoveCommentaire()
    {
        $commentaire = new Commentaire();
        $realisation = new Realisation();

        $this->assertEmpty($realisation->getCommentaires());

        $realisation->addCommentaire($commentaire);
        $this->assertContains($commentaire, $realisation->getCommentaires());

        $realisation->removeCommentaire($commentaire);
        $this->assertEmpty($realisation->getCommentaires());
    } 
    
    public function testAddGetRemoveCategorie()
    {
        $categorie = new Categorie();
        $realisation = new Realisation();

        $this->assertEmpty($realisation->getCategorie());

        $realisation->addCategorie($categorie);
        $this->assertContains($categorie, $realisation->getCategorie());

        $realisation->removeCategorie($categorie);
        $this->assertEmpty($realisation->getCategorie());
    } 
    
    public function testAddGetRemoveAttachment()
    {
        $attachment = new Attachment();
        $realisation = new Realisation();

        $this->assertEmpty($realisation->getAttachments());

        $realisation->addAttachment($attachment);
        $this->assertContains($attachment, $realisation->getAttachments());

        $realisation->removeAttachment($attachment);
        $this->assertEmpty($realisation->getAttachments());
    } 
}
