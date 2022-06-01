<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Deal;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(DealCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('3iL Symfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Homepage', 'fa fa-home', 'homepage');
        yield MenuItem::linkToCrud('Category', 'fa fa-shopping-basket', Category::class);
        yield MenuItem::linkToCrud('Deal', 'fa fa-barcode', Deal::class);
        yield MenuItem::linkToCrud('User', 'fa fa-user', User::class);
    }
}
