<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractDashboardController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(PictureCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    /**
     * Main Admin Dashboard Title
     * @return Dashboard
     */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mon Backoffice');
    }

    /**
     * Main menu items in left list
     * link here each entity crud we have
     * and/or ad more links
     * @return iterable
     */
    public function configureMenuItems(): iterable
    {   
        yield MenuItem::section('Home');
        yield MenuItem::linktoRoute('Accueil', 'fas fa-home', 'app_login');
        yield MenuItem::section('Site Public');
        yield MenuItem::linkToUrl('Front', 'fas fa-map', 'https://js.simschab.fr/cam/index.html');
        yield MenuItem::section('Administrer');
        yield MenuItem::linkToCrud('Images', 'fas fa-solid fa-image', Picture::class);
        

    }

}
