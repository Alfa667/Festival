<?php

namespace App\Controller;

use App\Entity\TypeChambre;
use App\Form\TypeChambreType;
use App\Repository\TypeChambreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/typeChambre')]
class TypeChambreController extends AbstractController
{
    #[Route('/', name: 'app_type_chambre_index', methods: ['GET'])]
    public function index(TypeChambreRepository $typeChambreRepository): Response
    {
        return $this->render('type_chambre/index.html.twig', [
            'type_chambres' => $typeChambreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_chambre_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function new(Request $request, TypeChambreRepository $typeChambreRepository): Response
    {
        $typeChambre = new TypeChambre();
        $form = $this->createForm(TypeChambreType::class, $typeChambre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeChambreRepository->save($typeChambre, true);

            return $this->redirectToRoute('app_type_chambre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_chambre/new.html.twig', [
            'type_chambre' => $typeChambre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_chambre_show', methods: ['GET'])]
    #[IsGranted("ROLE_ADMIN")]
    public function show(TypeChambre $typeChambre): Response
    {
        return $this->render('type_chambre/show.html.twig', [
            'type_chambre' => $typeChambre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_chambre_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function edit(Request $request, TypeChambre $typeChambre, TypeChambreRepository $typeChambreRepository): Response
    {
        $form = $this->createForm(TypeChambreType::class, $typeChambre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeChambreRepository->save($typeChambre, true);

            return $this->redirectToRoute('app_type_chambre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_chambre/edit.html.twig', [
            'type_chambre' => $typeChambre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_chambre_delete', methods: ['POST'])]
    public function delete(Request $request, TypeChambre $typeChambre, TypeChambreRepository $typeChambreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeChambre->getId(), $request->request->get('_token'))) {
            $typeChambreRepository->remove($typeChambre, true);
        }

        return $this->redirectToRoute('app_type_chambre_index', [], Response::HTTP_SEE_OTHER);
    }
}
