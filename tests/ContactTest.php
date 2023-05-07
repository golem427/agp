<?php

namespace App\Tests;

use App\Entity\Contact;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class contactTest extends TestCase
{
    public function testSIsTrue()
    {
        $contact=new Contact();
        $date = new DateTimeImmutable();

        $contact->setEmail('true@test.com')
                ->setNom('nom')
                ->setMessage('message')
                ->setCreatedAt($date)
                ->setIsSent(true);

        $this->assertTrue($contact->getEmail() === 'true@test.com');
        $this->assertTrue($contact->getNom() === 'nom');
        $this->assertTrue($contact->getMessage() === 'message');
        $this->assertTrue($contact->getCreatedAt() === $date);
        $this->assertTrue($contact->getIsSent() === true);
    }

    public function testSIsFalse()
    {
        $contact=new Contact();
        $date = new DateTimeImmutable();

        $contact->setEmail('true@test.com')
                ->setNom('nom')
                ->setMessage('message')
                ->setCreatedAt($date)
                ->setIsSent(true);

        $this->assertFalse($contact->getEmail() === 'false@test.com');
        $this->assertFalse($contact->getNom() === 'false');
        $this->assertFalse($contact->getMessage() === 'false');
        $this->assertFalse($contact->getCreatedAt() === new DateTimeImmutable());
        $this->assertFalse($contact->getIsSent() === 'false');
    }

    public function testSIsEmpty()
    {
        $contact=new contact();

        $this->assertEmpty($contact->getEmail());
        $this->assertEmpty($contact->getNom());
        $this->assertEmpty($contact->getMessage());
        $this->assertEmpty($contact->getIsSent());
    }
}
