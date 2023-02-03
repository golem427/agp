<?php

use app\Service\IsSent;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use App\Repository\ContactRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendContactCommand extends Command
{

        private $contactRepository;
        private $mailer;
        private $isSent;
        private $userRepository;
        protected static $defaultName = 'app:send-contact';

        public function __construct(
            ContactRepository $contactRepository,
            MailerInterface $mailer,
            IsSent $isSent,
            UserRepository $userRepository)
            {
                $this->contactRepository = $contactRepository;
                $this->mailer = $mailer;
                $this->IsSent = $isSent;
                $this->userRepository = $userRepository;
                parent::__construct();
            }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $toSend = $this->contactRepository->findBy(['IsSent' => false]);
            $adress = new Address ($this->UserRepository->getPeintre()->getEmail(), $this->UserRepository->getPeintre()->getNom());
        }
}