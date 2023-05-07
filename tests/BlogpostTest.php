<?php

namespace App\Tests;

use App\Entity\Blogpost;
use DateTime;
use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Commentaire;
use PHPUnit\Framework\TestCase;

class BlogpostTest extends TestCase
{
    public function testIsTrue(): void
    {   
        $blogpost = new Blogpost();
        $user = new User();

        $date = new DateTimeImmutable();
        $id = $user->getId();

            $blogpost->setTitre('titre')
                    ->setContenu('contenu')
                    ->setSlug('slug')
                    ->setCreatedAt($date)
                    ->setUser($user);

        $this->assertTrue($blogpost->getTitre() === 'titre');
        $this->assertTrue($blogpost->getContenu() === 'contenu');
        $this->assertTrue($blogpost->getCreatedAt() === $date);
        $this->assertTrue($blogpost->getUser() === $user);
        $this->assertTrue($blogpost->getId() === $id);
    }

    public function testIsFalse(): void
    {   
        $blogpost = new Blogpost();
        $user = new User();

        $date = new DateTimeImmutable();
        $update = new DateTime();

        $blogpost->setTitre('titre')
                    ->setContenu('contenu')
                    ->setSlug('slug')
                    ->setCreatedAt($date)
                    ->setUser($user);

        $this->assertFalse($blogpost->getTitre() === 'false');
        $this->assertFalse($blogpost->getContenu() === 'false');
        $this->assertFalse($blogpost->getSlug() === 'false');
        $this->assertFalse($blogpost->getCreatedAt() === new DateTimeImmutable());
        $this->assertFalse($blogpost->getUser() === new User());
    }

    public function testIsEmpty(): void
    {   
        $blogpost = new Blogpost();    

        $this->assertEmpty($blogpost->getTitre());
        $this->assertEmpty($blogpost->getContenu());
        $this->assertEmpty($blogpost->getSlug());
        $this->assertEmpty($blogpost->getUser());
        $this->assertEmpty($blogpost->getId());
    }

    public function testAddGetRemoveCommentaire()
    {
        $commentaire = new Commentaire();
        $blogpost = new Blogpost();

        $this->assertEmpty($blogpost->getCommentaires());

        $blogpost->addCommentaire($commentaire);
        $this->assertContains($commentaire, $blogpost->getCommentaires());

        $blogpost->removeCommentaire($commentaire);
        $this->assertEmpty($blogpost->getCommentaires());
    } 
}
