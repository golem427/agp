<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Form\ChangepwFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{

    #[Route(path: '/login', name: 'app_login')]
    public function login(
    AuthenticationUtils $authenticationUtils,
    ): Response
    {    
        if ($this->getUser()) {
            return $this->redirectToRoute('admin');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(AuthenticationUtils $authenticationUtils): Response
    {
        // throw new \LogicException('Oops, recommencez!');

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

   
     #[Route(path:'/changepw', name: 'changepw', methods: ['GET','POST'])]
      public function changePassword(EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(ChangepwFormType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            $user = $entityManager->getRepository(User::class)->upgradePassword();

            $this->addFlash('success', 'Votre mot de passe a été bien changé');
        }
        return $this->render('security/changepassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}