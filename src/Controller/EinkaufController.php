<?php

namespace App\Controller;

use App\Entity\Einkauf;
use App\Form\Einkauf1Type;
use App\Repository\EinkaufRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/einkauf')]
final class EinkaufController extends AbstractController
{
    #[Route(name: 'app_einkauf_index', methods: ['GET'])]
    public function index(EinkaufRepository $einkaufRepository): Response
{
    $einkaeufe = $einkaufRepository->findBy([], ['datum' => 'DESC']);
    $einkaufDetails = [];

    foreach ($einkaeufe as $einkauf) {
        $einkaufDetails[] = [
            'id' => $einkauf->getId(),
            'datum' => $einkauf->getDatum(),
            'menge' => $einkauf->getMengeKg(),
            'sorte' => $einkauf->getSorte()->getName(),
            'einkaufspreis' => $einkauf->getSorte()->getEinkaufspreisProKg()
        ];
    }

    return $this->render('einkauf/index.html.twig', [
        'einkaufDetails' => $einkaufDetails,
    ]);
}

    #[Route('/new', name: 'app_einkauf_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $einkauf = new Einkauf();
        $form = $this->createForm(Einkauf1Type::class, $einkauf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($einkauf);
            $entityManager->flush();

            return $this->redirectToRoute('app_einkauf_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('einkauf/new.html.twig', [
            'einkauf' => $einkauf,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_einkauf_show', methods: ['GET'])]
    public function show(Einkauf $einkauf): Response
    {
        return $this->render('einkauf/show.html.twig', [
            'einkauf' => $einkauf,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_einkauf_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Einkauf $einkauf, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Einkauf1Type::class, $einkauf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_einkauf_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('einkauf/edit.html.twig', [
            'einkauf' => $einkauf,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_einkauf_delete', methods: ['POST'])]
    public function delete(Request $request, Einkauf $einkauf, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$einkauf->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($einkauf);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_einkauf_index', [], Response::HTTP_SEE_OTHER);
    }
}
