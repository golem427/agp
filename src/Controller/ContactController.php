<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use app\Service\ContactService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, ContactService $contactService): Response
    {   
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
                
        if ($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();

            $contactService->persistContact($contact);

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/contact.html.twig',[
        'form' => $form->createView(),
        ]);     
    }
   
}
