<?php

namespace App\Command;

use App\Services\ContactService;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use App\Repository\ContactRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the "name" and "description" arguments of AsCommand replace the
// static $defaultName and $defaultDescription properties
#[AsCommand(
    name: 'app:send-contact',
    description: 'send a new message from client',
    hidden: false,
    aliases: ['app:send-contact']
)]
class SendContactCommand extends Command
{
    private $contactRepository;
    private $mailer;
    private $ContactService;
    private $UserRepository;

    public function __construct(
        ContactRepository $contactRepository,
        MailerInterface $mailer,
        ContactService $contactService,
        UserRepository $userRepository
    ) {
        $this->contactRepository = $contactRepository;
        $this->mailer = $mailer;
        $this->ContactService = $contactService;
        $this->UserRepository = $userRepository;
        parent::__construct();
    }
    
  
    protected function execute(InputInterface $input, OutputInterface $output):int
    {   
        $nom = $this->UserRepository->getNom();
        $email = $this->UserRepository->getEmail();

        $toSend = $this->contactRepository->findBy(['isSent' => false]);
        $address = new Address($nom, $email);

        foreach ($toSend as $mail) {
            $email = (new Email())  ->from($mail->getEmail())
                                    ->to($address)
                                    ->subject('Nouveau message de '. $mail->getNom())
                                    ->text($mail->getMessage());

            $this->mailer->send($email);

            $this->ContactService->isSent($mail);
        }

        return Command::SUCCESS;
    }
}