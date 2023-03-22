<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Services\ContactService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(
        Request $request,
        ContactService $contactService,
        EntityManagerInterface $manager,
        MailerInterface $mailer,
    ): Response 
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $contact = $form->getData();

                    $contactService->persistContact($contact);

                    $this->addFlash(
                        'success',
                        'Votre demande a bien été envoyée'
                    );
                    return $this->redirectToRoute('contact');
                }

            // $email = ( new TemplatedEmail())
            // ->from($contact->getEmail())
            // ->to('aguadopeinture@yahoo.com')
            // ->subject($contact->getSubject())
            // ->htmlTemplate('contact/contact.html.twig');
            // $mailer->send($email);
            
            return $this->render('contact/contact.html.twig', [
                'form' => $form->createView(),
                ]);          
    }
}
