<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, EntityManagerInterface $manager): Response
    {   
       

        $contact = new Contact();
        $contact->setIsSent('false')
                ->setCreatedAt(new DateTime('now'));

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $contact = $form->getData();
           
            $manager->persist($contact);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre demande a bien été envoyée'
            );
              
        return $this->redirectToRoute('contact');
    }
    return $this->render('contact/contact.html.twig',[
        'form' => $form->createView(),
        ]);     
    }

    
    public function IsSent(Contact $contact, EntityManagerInterface $manager):void{

        $contact->setIsSent('true');

        $this->$manager->persist($contact);
        $this->$manager->flush();

                
    }
}
