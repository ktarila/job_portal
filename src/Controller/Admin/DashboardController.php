<?php

namespace App\Controller\Admin;

use App\Controller\Admin\CountryCrudController;
use App\Entity\Country;
use App\Entity\State;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $applicationsUrl = $this->get(CrudUrlGenerator::class)->build()->setController(CountryCrudController::class)->generateUrl();

        return $this->redirect($applicationsUrl);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Job Portal');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Home', 'fa fa-home', 'home');
        yield MenuItem::linkToCrud('Country', 'fa fa-flag', Country::class);
        yield MenuItem::linkToCrud('State', 'fa fa-flag', State::class);
    }
}
