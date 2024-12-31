<?php

namespace App\Controller;

use App\Entity\Sorte;

use App\Entity\Treuepunkte;
use App\Form\TreuepunkteType;
use App\Repository\TreuepunkteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/treuepunkte')]
final class TreuepunkteController extends AbstractController
{
    #[Route(name: 'app_treuepunkte_index', methods: ['GET'])]
    public function index(TreuepunkteRepository $treuepunkteRepository): Response
    {
        $treuepunkte = $treuepunkteRepository->findBy([], ['datum' => 'DESC']);
        $treuepunkteDetails = [];

        foreach ($treuepunkte as $punkt) {
            $treuepunkteDetails[] = [
                'id' => $punkt->getId(),
                'name' => $punkt->getName(),
                'datum' => $punkt->getDatum(),
                'menge' => $punkt->getMenge(),
                'sorte' => $punkt->getSorte()->getName(),
                'preis1g' => $punkt->getSorte()->getVerkaufspreis1g(),
                    'preis05g' => $punkt->getSorte()->getVerkaufspreis05g(),
                'erledigt' => $punkt->isErledigt()
            ];
        }

        return $this->render('treuepunkte/index.html.twig', [
            'treuepunkteDetails' => $treuepunkteDetails,
        ]);
    }

    #[Route('/new', name: 'app_treuepunkte_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $treuepunkte = new Treuepunkte();
        $form = $this->createForm(TreuepunkteType::class, $treuepunkte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($treuepunkte);
            $entityManager->flush();

            return $this->redirectToRoute('app_treuepunkte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('treuepunkte/new.html.twig', [
            'treuepunkte' => $treuepunkte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_treuepunkte_show', methods: ['GET'])]
    public function show(Treuepunkte $treuepunkte): Response
    {
        return $this->render('treuepunkte/show.html.twig', [
            'treuepunkte' => $treuepunkte,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_treuepunkte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Treuepunkte $treuepunkte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TreuepunkteType::class, $treuepunkte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_treuepunkte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('treuepunkte/edit.html.twig', [
            'treuepunkte' => $treuepunkte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_treuepunkte_delete', methods: ['POST'])]
    public function delete(Request $request, Treuepunkte $treuepunkte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$treuepunkte->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($treuepunkte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_treuepunkte_index', [], Response::HTTP_SEE_OTHER);
    }
}
