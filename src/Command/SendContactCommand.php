<?php



use App\Repository\ContactRepository;
use App\Repository\UserRepository;
use App\Service\ContactService;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class SendContactCommand extends Command
{

    private $contactRepository;
    private $mailer;
    private $contactService;
    public $userRepository;
    protected static $defaultName = 'app:send-contact';

    public function __construct(
        ContactRepository $contactRepository,
        MailerInterface $mailer,
        ContactService $contactService,
        UserRepository $userRepository
    ) {
        $this->contactRepository = $contactRepository;
        $this->mailer = $mailer;
        $this->contactService = $contactService;
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $toSend = $this->contactRepository->findBy(['IsSent' => false]);
        $address = new Address(
        $this->userRepository->getPeintre()->getEmail(),
        $this->userRepository->getPeintre()->getPrenom(),
        $this->userRepository->getPeintre()->getNom()
    );

        foreach ($toSend as $mail) {
            $email = (new Email())
                ->from($mail->getEmail())
                ->to('Aguado-Peinture')
                ->subject('Nouveau message de ' . $mail->getNom())
                ->text($mail->getMessage());

                $this->mailer->send($email);
                $this->contactService->isSent($mail);
        }
        
        return Command::SUCCESS;
    }
}
