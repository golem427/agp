<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use DateTimeImmutable;
use App\Form\RegisterType;
use App\Form\ChangepwFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
  
#[Route('/user', name: 'register', methods:['GET','POST'])]
public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        # 1 - Instanciation de la classe
        $user = new User();

        # 2 - Création du formulaire
        $form = $this->createForm(RegisterType::class, $user)
            ->handleRequest($request);

        # 3 - Si le form est soumis ET valide
        if($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(new DateTimeImmutable());
            $user->setUpdatedAt(new DateTime());

            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', "Vous vous êtes inscrit avec succès !");
            return $this->redirectToRoute('app_login');
        }

        # 4 - On retourne la vue du formulaire
        return $this->render("user/register.html.twig", [
            'form' => $form->createView()
        ]);
    }

    #[Route(path:'/user', name: 'changepw', methods: ['GET','POST'])]
    public function changePassword(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, Request $request): Response
    {
        $form = $this->createForm(ChangepwFormType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $this->getUser()]);
            $user->setUpdatedAt(new DateTime());

            $user->setPassword($passwordHasher
            ->hashPassword($user, 
            $form->get('plainPassword')->getData()

                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été bien changé');
            return $this->redirectToRoute('admin');
        }

        return $this->render('user/changepw.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }
}
