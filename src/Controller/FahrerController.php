<?php

namespace App\Controller;

use App\Entity\Fahrer;
use App\Form\Fahrer1Type;
use App\Repository\FahrerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/fahrer')]
final class FahrerController extends AbstractController
{
    #[Route(name: 'app_fahrer_index', methods: ['GET'])]
    public function index(FahrerRepository $fahrerRepository): Response
    {
        return $this->render('fahrer/index.html.twig', [
            'fahrers' => $fahrerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_fahrer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fahrer = new Fahrer();
        $form = $this->createForm(Fahrer1Type::class, $fahrer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fahrer);
            $entityManager->flush();

            return $this->redirectToRoute('app_fahrer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fahrer/new.html.twig', [
            'fahrer' => $fahrer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fahrer_show', methods: ['GET'])]
    public function show(Fahrer $fahrer): Response
    {
        return $this->render('fahrer/show.html.twig', [
            'fahrer' => $fahrer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fahrer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fahrer $fahrer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Fahrer1Type::class, $fahrer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_fahrer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fahrer/edit.html.twig', [
            'fahrer' => $fahrer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fahrer_delete', methods: ['POST'])]
    public function delete(Request $request, Fahrer $fahrer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fahrer->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($fahrer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_fahrer_index', [], Response::HTTP_SEE_OTHER);
    }
}
