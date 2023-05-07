<?php

namespace App\Tests;

use App\Entity\User;
use App\Entity\Categorie;
use App\Entity\Realisation;
use PHPUnit\Framework\TestCase;

class CategorieTest extends TestCase
{
    public function testSIsTrue()
    {
        $categorie=new Categorie();

        $categorie->setNom('nom');
        $categorie->setDescription('description');
        $categorie->setSlug('slug');

        $this->assertTrue($categorie->getNom() === 'nom');
        $this->assertTrue($categorie->getDescription() === 'description');
        $this->assertTrue($categorie->getSlug() === 'slug');
    }

    public function testSIsFalse()
    {
        $categorie=new Categorie();

        $categorie->setNom('nom');
        $categorie->setDescription('description');
        $categorie->setSlug('slug');

        $this->assertFalse($categorie->getNom() === 'false');
        $this->assertFalse($categorie->getDescription() === 'false');
        $this->assertFalse($categorie->getSlug() === 'false');
    }

    public function testSIsEmpty()
    {
        $categorie=new Categorie();

        $this->assertEmpty($categorie->getNom());
        $this->assertEmpty($categorie->getDescription());
        $this->assertEmpty($categorie->getSlug());
    }

    public function testAddGetRemoveRealisation()
    {
        $categorie=new Categorie();
        $realisation = new Realisation();

        $this->assertEmpty($categorie->getRealisations());

        $categorie->addRealisation($realisation);
        $this->assertContains($realisation, $categorie->getRealisations());

        $categorie->removeRealisation($realisation);
        $this->assertEmpty($categorie->getRealisations());
    } 
}
