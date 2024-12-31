<?php

namespace App\Controller\Admin;

use App\Entity\Einkauf;
use App\Entity\Sorte;
use App\Entity\Verkauf;
use App\Entity\Fahrer;
use App\Entity\User;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private ChartBuilderInterface $chartBuilder,
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
       
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        # $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        # return $this->redirect($adminUrlGenerator->setController(SorteCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render('admin/dashboard.html.twig', [
            'chart' => $chart,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="/assets/images/windmill-1_A-diF.svg" height="30"> <span class="knewave-regular">FlourExpress</span>');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::linkToRoute('Statistik', 'fa fa-chart-bar', 'statistik'),

            MenuItem::section('Mehl'),
            MenuItem::linkToCrud('Sorte', 'fa fa-bread-slice', Sorte::class),
            MenuItem::linkToCrud('Einkauf', 'fa fa-receipt', Einkauf::class),
            MenuItem::linkToCrud('Verkauf', 'fa fa-coins', Verkauf::class),



            MenuItem::section('Fahrer'),
            MenuItem::linkToCrud('Daten', 'fa fa-user', Fahrer::class),
            MenuItem::linkToRoute('Umsätze', 'fa fa-money-bill', 'fahrer_verguetung'),

            MenuItem::section('User'),
            MenuItem::linkToCrud('Daten', 'fa fa-user', User::class),
           
        ];
    }
}
