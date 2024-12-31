<?php

namespace App\Controller;

use App\Entity\Verkauf;
use App\Form\Verkauf1Type;
use App\Repository\VerkaufRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/verkauf')]
final class VerkaufController extends AbstractController
{
    #[Route(name: 'app_verkauf_index', methods: ['GET'])]
    public function index(VerkaufRepository $verkaufRepository): Response
    {
        $verkauefe = $verkaufRepository->findBy([], ['datum' => 'ASC']);
        $verkaufDetails = [];
    
        foreach ($verkauefe as $verkauf) {

            $gesamtGramm = ($verkauf->getMenge1g() * 1) + ($verkauf->getMenge05g() * 0.5);


            $verkaufDetails[] = [
                'id' => $verkauf->getId(),
                'datum' => $verkauf->getDatum(),
                'menge1g' => $verkauf->getMenge1g(),
                'menge05g' => $verkauf->getMenge05g(),
                'gesamtGramm' => $gesamtGramm,
                'fahrer' => $verkauf->getFahrer()->getName(),
                'sorte' => $verkauf->getSorte()->getName()
            ];
        }
    
        return $this->render('verkauf/index.html.twig', [
            'verkaufDetails' => $verkaufDetails,
        ]);
    }

    #[Route('/new', name: 'app_verkauf_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $verkauf = new Verkauf();
        $form = $this->createForm(Verkauf1Type::class, $verkauf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($verkauf);
            $entityManager->flush();

            return $this->redirectToRoute('app_verkauf_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('verkauf/new.html.twig', [
            'verkauf' => $verkauf,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_verkauf_show', methods: ['GET'])]
    public function show(Verkauf $verkauf): Response
    {
        return $this->render('verkauf/show.html.twig', [
            'verkauf' => $verkauf,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_verkauf_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Verkauf $verkauf, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Verkauf1Type::class, $verkauf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_verkauf_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('verkauf/edit.html.twig', [
            'verkauf' => $verkauf,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_verkauf_delete', methods: ['POST'])]
    public function delete(Request $request, Verkauf $verkauf, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$verkauf->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($verkauf);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_verkauf_index', [], Response::HTTP_SEE_OTHER);
    }
}
