<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Realisation;
use App\Form\CommentaireType;
use App\Services\CommentaireService;
use App\Repository\CommentaireRepository;
use App\Repository\RealisationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RealisationsController extends AbstractController
{
    #[Route('/realisations', name:'realisations')]
    public function realisations(
        RealisationRepository $realisationRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $realisationRepository->findBy([], ['id'=>'DESC']);

        $realisations = $paginator->paginate($data, $request->query->getInt('page', 1), 6);
        //Le "paginate demande un "integer" pour les n° d 'page', qui démarre à 1 et limite à 6 les résultats par page.

        return $this->render('realisations/realisations.html.twig', [
            'realisations' => $realisations
        ]);
    }

    #[Route('/realisations/{slug}', name:'real_details')]
    public function detailRealisation(
        Realisation $realisation,
        Request $request,
        CommentaireService $commentaireService,
        CommentaireRepository $commentaireRepository,
    ): Response {
        $commentaires = $commentaireRepository->findCommentaires($realisation);
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire = $form->getData();
            $commentaireService->persistCommentaire($commentaire, $realisation, null);

            $this->addFlash(
                type: 'success',
                message: 'Votre commentaire a bien été envoyé, il sera visible après modération.'
            );

            return $this->redirectToRoute('real_details', [
               'slug' => $realisation->getSlug()
               ]);
        }

        return $this->render('realisations/realisationsdetails.html.twig', [

             'realisation' => $realisation,
             'form' => $form->createView(),
             'commentaires'=> $commentaires

        ]);
    }

        #[Route('/', name:'realisation_home')]
        public function realisationHome(Realisation $realisation): Response
        {
            return $this->render('/realisation.html.twig', [
                'realisation' => $realisation
            ]);
        }

        #[Route('/realisation/{id}/realisationslider', name: 'realisation_slider')]
        public function realisationslider(int $id, RealisationRepository $repository): Response
        {   
            $realisations = $repository->findAll();
            $realisation = $repository->findOneWithAttachments($id);

            if (!$realisation) {
                throw $this->createNotFoundException('Realisation not found');
            }

            $attachments = $realisation->getAttachments();

            return $this->render('/realisations/realisationslider.html.twig', [
                'realisation' => $realisation,
                'attachments' => $attachments,
            ]);
        }
}