<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function sendEmail(Request $request, MailerInterface $mailer, EntityManagerInterface $manager): Response 
    {   
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        $contact = new Contact();
      
                if ($form->isSubmitted() && $form->isValid()) 
                {   
                  $contact = $form->getData();
                    $manager->persist($contact);
                    $manager->flush();

                    $address = $contact->getEmail();
                    $subject = $contact->getSubject();
                    $message = $contact->getMessage();

                            $email = (new Email())
                                ->from($address)
                                ->to('aguadopeinture@yahoo.com')
                                ->subject($subject)
                                ->text($message);
                                // ->htmlTemplate('contact/email.html.twig')

                            $mailer->send($email);

                            $this->addFlash('success', 'Votre demande a bien été envoyée');

                            return $this->redirectToRoute('contact');
                        } 
                    
                        return $this->render('contact/contact.html.twig', [
                            'controller_name' => 'ContactController',
                            'form' => $form
                            ]);                                    
    }
}