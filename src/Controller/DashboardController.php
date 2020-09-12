<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Conference;
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
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(ConferenceCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('GuestBook Dashboard');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Back to homepage', 'fa fa-home', 'homepage');
        yield MenuItem::linkToCrud('Conferences', 'fa fa-users', Conference::class);
        yield MenuItem::linkToCrud('Comments', 'fa fa-comments', Comment::class);
    }
}
