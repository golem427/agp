<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function sendEmail(Request $request, MailerInterface $mailer
    ): Response 
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
      
                if ($form->isSubmitted() && $form->isValid()) 
                {
                    $data = $form->getData();

                    $nom = $data->getNom();
                    $address = $data->getEmail();
                    $subject = $data->getSubject();
                    $content = $data->getMessage();
                  

                        $email = (new Email())
                                ->from($address)
                                ->to('aguadopeinture@yahoo.com')
                                ->subject($subject)
                                ->text($content);

                        $mailer->send($email);
                }        
                        return $this->render('contact/contact.html.twig', [
                            'controller_name' =>'ContactController',
                            'form' => $form
                            ]);                            
    }
}