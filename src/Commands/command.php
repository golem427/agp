<?php

namespace App\Command;

use App\Services\ContactService;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Repository\ContactRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;



class SendContactCommand extends Command
{
    private $ContactRepositoryContactRepository;
    private $mailer;
    private $ContactService;
    private $userRepository;
    protected static $defaultName = 'app:send-contact';

    public function __construct(
        ContactRepository $contactRepository,
        MailerInterface $mailer,
        ContactService $contactService,
        UserRepository $userRepository,
    ) {
        $this->contactRepository = $contactRepository;
        $this->mailer = $mailer;
        $this->contactService = $contactService;
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $toSend = $this->contactRepository->findBy(['isSent' => false]);
        $address = new Address($this->userRepository->getUser()->getEmail(), 
        $this->userRepository->getUser()->getNom());

        foreach ($toSend as $mail){

            $email = (new Email())  ->from($mail->getEmail())
                                    ->to($address)
                                    ->subject('Nouveau message de '. $mail->getNom () )
                                    ->text($mail->getMessage());

            $this->mailer->send($email);

            $this->ContactService->isSent($mail);
       }

       return Command::SUCCESS;
    }
}