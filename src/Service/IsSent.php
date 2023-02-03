<?php
    
namespace app\Service;

use DateTime;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class IsSent{

    private $manager;
    private $flash;

    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flash, Contact $contact)
    {
        $this->manager = $manager;
        $this->flash = $flash;
        $contact->setIsSent(false)
                ->setCreatedAt(new DateTime('now'));

            $manager->persist($contact);
            $manager->flush();

    }


}