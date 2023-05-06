<?php

namespace App\Tests;

use App\Entity\Blogpost;
use App\Entity\Realisation;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testSIsTrue()
    {
        $user=new User();

        $user->setEmail('true@test.com');
        $user->setNom('nom');
        $user->setPassword('password');

        $this->assertTrue($user->getEmail() === 'true@test.com');
        $this->assertTrue($user->getNom() === 'nom');
        $this->assertTrue($user->getPassword() === 'password');
    }

    public function testSIsFalse()
    {
        $user=new User();

        $user->setEmail('true@test.com');
        $user->setNom('nom');
        $user->setPassword('password');

        $this->assertFalse($user->getEmail() === 'false@test.com');
        $this->assertFalse($user->getNom() === 'false');
        $this->assertFalse($user->getPassword() === 'false');
    }

    public function testSIsEmpty()
    {
        $user=new User();

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getNom());
        $this->assertEmpty($user->getPassword());
    }

    public function testAddGetRemoveRealisation()
    {
        $user=new User();
        $realisation = new Realisation();

        $this->assertEmpty($user->getRealisations());

        $user->addRealisation($realisation);
        $this->assertContains($realisation, $user->getRealisations());

        $user->removeRealisation($realisation);
        $this->assertEmpty($user->getRealisations());
    }

    public function testAddGetRemoveBlogpost()
    {
        $user=new User();
        $blogpost = new Blogpost();

        $this->assertEmpty($user->getBlogposts());

        $user->addBlogpost($blogpost);
        $this->assertContains($blogpost, $user->getBlogposts());

        $user->removeBlogpost($blogpost);
        $this->assertEmpty($user->getBlogposts());
    }    
}
