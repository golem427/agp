<?php

namespace App\Services;

use DateTimeImmutable;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;

class ContactService
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function persistContact(Contact $contact): void 
    {
        $contact->setIsSent(false)
                ->setCreatedAt(new DateTimeImmutable());
        $this->em->persist($contact);
        $this->em->flush();
    }
    public function IsSent(Contact $contact): void 
    {
        $contact->setIsSent(true);
        $this->em->persist($contact);
        $this->em->flush();
    }
}
 ////////////////////////////Ne pas oublier de faire un CRON en prod !!! ///////////////////////////////////////////////////