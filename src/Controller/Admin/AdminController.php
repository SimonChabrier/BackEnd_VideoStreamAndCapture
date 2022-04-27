<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="app_admin")
     * composer require symfony/mime
     */
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(PictureCrudController::class)->generateUrl();

        return $this->redirect($url);
    }
    /**
     * Main Admin Dashboard
     *
     * @return Dashboard
     */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('BackOffice JS-PB');
    }

    /**
     * Main menu items
     * linked to each entity crud we have
     * @return iterable
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Accueil', 'fas fa-home', 'app_login');
        yield MenuItem::linkToCrud('Images', 'fas fa-solid fa-image', Picture::class);

    }


}
