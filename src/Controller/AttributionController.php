<?php

namespace App\Controller;

use App\Entity\Attribution;
use App\Entity\Offre;
use App\Form\AttributionType;
use App\Repository\AttributionRepository;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/attribution')]
class AttributionController extends AbstractController
{
    #[Route('/', name: 'app_attribution_index', methods: ['GET'])]
    public function index(AttributionRepository $attributionRepository): Response
    {
        return $this->render('attribution/index.html.twig', [
            'attributions' => $attributionRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_attribution_show', methods: ['GET'])]
    #[IsGranted("ROLE_ADMIN")]
    public function show(Attribution $attribution): Response
    {
        return $this->render('attribution/show.html.twig', [
            'attribution' => $attribution,
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_attribution_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function edit(Request $request, Attribution $attribution, AttributionRepository $attributionRepository, OffreRepository $offreRepository): Response
    {
        $form = $this->createForm(AttributionType::class, $attribution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nbCUpdate = $attribution->getNombreChambres();
            $nbCAncienne = $form->get('nombreChambres')->getData();
            $nbC = $nbCUpdate - $nbCAncienne;
          
            if($nbCUpdate> $nbCAncienne) {
                dump($$attribution->getOffre()->getNombreChambres()    -$nbC);
            $attribution->getOffre()->setNombreChambres($attribution->getOffre()->getNombreChambres()    -$nbC);

            $offreRepository->save($attribution->getOffre(), true);

        }else {
            dump($$attribution->getOffre()->getNombreChambres()    +$nbC);
            $attribution->getOffre()->setNombreChambres($attribution->getOffre()->getNombreChambres()   +$nbC);
            $offreRepository->save($attribution->getOffre(), true);
        }
           
       
            $attributionRepository->save($attribution, true);

            //return $this->redirectToRoute('app_attribution_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('attribution/edit.html.twig', [
            'attribution' => $attribution,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/new', name: 'app_attribution_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function new(Request $request, AttributionRepository $attributionRepository , Offre $offre, OffreRepository $offreRepository): Response
    {
        $attribution = new Attribution();
        $form = $this->createForm(AttributionType::class, $attribution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            dump($offre);
            $attribution->setOffre($offre);
            $offre->setNombreChambres($offre->getNombreChambres()-$attribution->getNombreChambres());
            $offreRepository->save($offre, true);
            
            $attributionRepository->save($attribution, true);

            return $this->redirectToRoute('app_attribution_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('attribution/new.html.twig', [
            'attribution' => $attribution,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_attribution_delete', methods: ['POST'])]
    public function delete(Request $request, Attribution $attribution, AttributionRepository $attributionRepository, OffreRepository $offreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attribution->getId(), $request->request->get('_token'))) {

            $offre = $attribution->getOffre();
            $offre->setNombreChambres($offre->getNombreChambres()+$attribution->getNombreChambres());
            $offreRepository->save($offre, true);
            $attributionRepository->remove($attribution, true);
        }

        return $this->redirectToRoute('app_attribution_index', [], Response::HTTP_SEE_OTHER);
    }
}



                


