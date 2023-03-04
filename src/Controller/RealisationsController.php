<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Realisation;
use App\Form\CommentaireType;
use App\Service\CommentaireService;
use App\Repository\CommentaireRepository;
use App\Repository\RealisationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


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

    #[Route('/realisations/{slug}', name:'realisations_details')]
    #[ParamConverter('realisation', options: ['mapping' => ['realisationSlug' => 'slug']])]
    public function addCommentRealisation(
        Realisation $realisation,
        Request $request,
        Commentaire $commentaire,
        CommentaireService $commentaireService,
        CommentaireRepository $commentaireRepository,
       
    ): Response 
    {
        $commentaire = new Commentaire();
        $commentaires = $commentaireRepository->findCommentaires($realisation);

        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire = $form->getData();
            $commentaireService->persistCommentaire($commentaire, null, $realisation);

            return $this->redirectToRoute('realisations_details', ['slug' => $realisation->getSlug()]);
        }
        return $this->render(
            'realisations/realisationsdetails.html.twig',
            [
                'realisation' => $realisation,
                'form' => $form->createView(),
                'commentaires' => $commentaires,
            ]
        );
    }

        #[Route('/', name:'realisation_home')]
        public function realisationHome(Realisation $realisation): Response
        {
            return $this->render('/realisation.html.twig', [
                'realisation' => $realisation
            ]);
        }
}
