<?php

namespace App\Controller;

use App\Entity\Realisation;
use App\Form\RealisationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RealisationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/realisation')]
class RealisationController extends AbstractController
{
    #[Route('/', name: 'app_realisation_index', methods: ['GET'])]
    public function index(RealisationRepository $realisationRepository): Response
    {
        return $this->render('realisation/index.html.twig', [
            'realisations' => $realisationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_realisation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RealisationRepository $realisationRepository): Response
    {
        $realisation = new Realisation();
        $form = $this->createForm(RealisationType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on récupère les images transmises dans attachement
            $image = $form->get('images')->getData();
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager=$this->persist('realisation');
            $entityManager=$this->flush();
            

            return $this->redirectToRoute('app_realisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('realisation/new.html.twig',
        [
            'realisation' => $realisation,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_realisation_show', methods: ['GET'])]
    public function show(Realisation $realisation): Response
    {
        return $this->render('realisation/show.html.twig', [
            'realisation' => $realisation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_realisation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Realisation $realisation, RealisationRepository $realisationRepository): Response
    {
        $form = $this->createForm(RealisationType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $realisationRepository->save($realisation, true);

            return $this->redirectToRoute('app_realisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('realisation/edit.html.twig', [
            'realisation' => $realisation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_realisation_delete', methods: ['POST'])]
    public function delete(Request $request, Realisation $realisation, RealisationRepository $realisationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$realisation->getId(), $request->request->get('_token'))) {
            $realisationRepository->remove($realisation, true);
        }

        return $this->redirectToRoute('app_realisation_index', [], Response::HTTP_SEE_OTHER);
    }
}
