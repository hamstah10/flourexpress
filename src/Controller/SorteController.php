<?php

namespace App\Controller;

use App\Entity\Sorte;
use App\Form\Sorte1Type;
use App\Repository\SorteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sorte')]
final class SorteController extends AbstractController
{
    #[Route(name: 'app_sorte_index', methods: ['GET'])]
    public function index(SorteRepository $sorteRepository): Response
    {
        return $this->render('sorte/index.html.twig', [
            'sortes' => $sorteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sorte_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sorte = new Sorte();
        $form = $this->createForm(Sorte1Type::class, $sorte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sorte);
            $entityManager->flush();

            return $this->redirectToRoute('app_sorte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sorte/new.html.twig', [
            'sorte' => $sorte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sorte_show', methods: ['GET'])]
    public function show(Sorte $sorte): Response
    {
        return $this->render('sorte/show.html.twig', [
            'sorte' => $sorte,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sorte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sorte $sorte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Sorte1Type::class, $sorte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sorte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sorte/edit.html.twig', [
            'sorte' => $sorte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sorte_delete', methods: ['POST'])]
    public function delete(Request $request, Sorte $sorte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sorte->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sorte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sorte_index', [], Response::HTTP_SEE_OTHER);
    }
}
