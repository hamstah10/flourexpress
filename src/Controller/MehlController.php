<?php
namespace App\Controller;

use App\Entity\Sorte;
use App\Entity\Einkauf;
use App\Entity\Verkauf;
use App\Entity\Fahrer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\EinkaufType;
use App\Form\VerkaufType;
use App\Form\FahrerType;
use App\Form\SorteType;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;

use Symfony\Component\Routing\Attribute\Route;


class MehlController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    #[Route("/", name: "app_start")]
    public function index(): Response
    {
        return $this->render('mehl/index.html.twig', [
            'controller_name' => 'Mehl',
        ]);
    }
   
     #[Route("/einkauf_index", name: "einkauf_index")]
    public function einkauf(Request $request): Response
    {
        $einkauf = new Einkauf();
        $form = $this->createForm(EinkaufType::class, $einkauf);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($einkauf);
            $this->entityManager->flush();
            $this->addFlash('success', 'Einkauf erfolgreich gespeichert!');
            return $this->redirectToRoute('einkauf');
        }

        return $this->render('einkauf.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/sorte_index", name: "sorte_index")]
    public function sorte(Request $request): Response
    {
        $sorte = new Sorte();
        $form = $this->createForm(SorteType::class, $sorte);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($sorte);
            $this->entityManager->flush();
            $this->addFlash('success', 'Einkauf erfolgreich gespeichert!');
            return $this->redirectToRoute('sorte_index');
        }

        return $this->render('sorte.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/verkauf_index", name: "verkau_index")]
    public function verkauf(Request $request): Response
    {
        $verkauf = new Verkauf();
        $form = $this->createForm(VerkaufType::class, $verkauf);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Der Fahrer wird automatisch aus dem Formular zugewiesen
            $this->entityManager->persist($verkauf);
            $this->entityManager->flush();
            $this->addFlash('success', 'Verkauf erfolgreich gespeichert!');
            return $this->redirectToRoute('verkauf');
        }

        return $this->render('verkauf.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
    #[Route("/umsatz", name: "umsatz")]
    public function umsatz(Request $request, DataTableFactory $dataTableFactory): Response
{
    $umsatz = $this->entityManager->getRepository(Verkauf::class)
        ->findBy([], ['datum' => 'ASC']);
        
    $gewinn = 0;
    $gesamtFahrerkosten = 0;
    $gesamtEinnahmen = 0;
    $verkaufDetails = [];

    $table = $dataTableFactory->create()
            ->add('firstName', TextColumn::class)
            ->add('lastName', TextColumn::class)
            ->createAdapter(ArrayAdapter::class, [
                ['firstName' => 'Donald', 'lastName' => 'Trump'],
                ['firstName' => 'Barack', 'lastName' => 'Obama'],
            ])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

    foreach ($umsatz as $v) {
        $sorte = $v->getSorte();
        $fahrer = $v->getFahrer();
        
        // Berechne Einnahmen
        $einnahmen = ($v->getMenge1g() * $sorte->getVerkaufspreis1g()) + 
                    ($v->getMenge05g() * $sorte->getVerkaufspreis05g());
        
        $gesamtEinnahmen += $einnahmen;
        
        // Berechne Fahrerkosten
        $fahrerkosten = ($v->getMenge1g() * $fahrer->getVerguetung1g()) +
                       ($v->getMenge05g() * $fahrer->getVerguetung05g());
        
        $gesamtFahrerkosten += $fahrerkosten;
        $gewinn += ($einnahmen - $fahrerkosten);

        $verkaufDetails[] = [
            'datum' => $v->getDatum(),
            'fahrer' => $fahrer->getName(),
            'sorte' => $sorte->getName(),
            'menge1g' => $v->getMenge1g(),
            'menge05g' => $v->getMenge05g(),
            'einnahmen' => $einnahmen,
            'fahrerkosten' => $fahrerkosten,
            'gewinnProVerkauf' => $einnahmen - $fahrerkosten,
            
        ];
            //var_dump($verkaufDetails);
    }

    return $this->render('umsatz.html.twig', [
        'verkaufDetails' => $verkaufDetails,
        'gesamterGewinn' => $gewinn,
        'gesamtFahrerkosten' => $gesamtFahrerkosten,
        'gesamtEinnahmen' => $gesamtEinnahmen,
        'datatable' => $table
    ]);
}


   
     #[Route("/statistik", name: "statistik")]    
  public function statistik(): Response
{
    // Holen Sie sich alle Verkäufe
    $verkäufe = $this->entityManager->getRepository(Verkauf::class)->findAll();
    $fahrerVerguetung = [];
    $gesamtEinnahmen = 0;

    foreach ($verkäufe as $verkauf) {
        $sorte = $verkauf->getSorte();
        $fahrer = $verkauf->getFahrer();

        // Einnahmen berechnen
        $einnahme = ($verkauf->getMenge1g() * $sorte->getVerkaufspreis1g()) + ($verkauf->getMenge05g() * $sorte->getVerkaufspreis05g());
        $gesamtEinnahmen += $einnahme;

        // Fahrervergütung berechnen
        if ($fahrer) {
            $verguetung1g = $fahrer->getVerguetung1g() * $verkauf->getMenge1g();
            $verguetung05g = $fahrer->getVerguetung05g() * $verkauf->getMenge05g();

            if (!isset($fahrerVerguetung[$fahrer->getId()])) {
                $fahrerVerguetung[$fahrer->getId()] = [
                    'fahrerName' => $fahrer->getName(),
                    'totalVerguetung' => 0,
                ];
            }

            $fahrerVerguetung[$fahrer->getId()]['totalVerguetung'] += $verguetung1g + $verguetung05g;
        }
    }

    return $this->render('statistik.html.twig', [
        'gesamtEinnahmen' => $gesamtEinnahmen,
        'fahrerVerguetung' => $fahrerVerguetung,
    ]);
}


    
     #[Route("/fahrer", name: "fahrer")]
    public function fahrer(Request $request): Response
    {
        $fahrer = new Fahrer();
        $form = $this->createForm(FahrerType::class, $fahrer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($fahrer);
            $this->entityManager->flush();
            $this->addFlash('success', 'Fahrer erfolgreich gespeichert!');
            return $this->redirectToRoute('fahrer');
        }

        $fahrerListe = $this->entityManager->getRepository(Fahrer::class)->findAll();

        return $this->render('fahrer.html.twig', [
            'form' => $form->createView(),
            'fahrerListe' => $fahrerListe,
        ]);
    }

    
    #[Route("/fahrer-verguetung", name:"fahrer_verguetung")]
    public function fahrerVerguetung(): Response
    {
        $verkaeufe = $this->entityManager->getRepository(Verkauf::class)->findAll();
        $fahrerVerguetung = [];

        foreach ($verkaeufe as $verkauf) {
            $fahrer = $verkauf->getFahrer();
            if ($fahrer) {
                $sorte = $verkauf->getSorte();
                $verguetung1g = $fahrer->getVerguetung1g() * $verkauf->getMenge1g();
                $verguetung05g = $fahrer->getVerguetung05g() * $verkauf->getMenge05g();

                if (!isset($fahrerVerguetung[$fahrer->getId()])) {
                    $fahrerVerguetung[$fahrer->getId()] = [
                        'fahrerName' => $fahrer->getName(),
                        'totalVerguetung' => 0,
                    ];
                }

                $fahrerVerguetung[$fahrer->getId()]['totalVerguetung'] += $verguetung1g + $verguetung05g;
            }
        }

        return $this->render('fahrer_verguetung.html.twig', [
            'fahrerVerguetung' => $fahrerVerguetung,
        ]);
    }
}
