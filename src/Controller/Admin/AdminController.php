<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
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
            ->setTitle('<img src="https://picsum.photos/100/100"/>');
    }

    /**
     * Main menu items in left list
     * link here each entity crud we have
     * and/or ad more links
     * https://symfony.com/doc/current/EasyAdminBundle/dashboards.html#menu-item-configuration-options
     * @return iterable
     */
    public function configureMenuItems(): iterable
    {   
        yield MenuItem::linkToLogout('Logout', 'fa fa-fw fa-sign-out');
        yield MenuItem::section('Home');
        yield MenuItem::linktoRoute('Accueil', 'fas fa-home', 'app_login');
        yield MenuItem::section('Site Public');
        yield MenuItem::linkToUrl('Front', 'fas fa-map', 'https://js.simschab.fr/cam/index.html');
        yield MenuItem::section('Administrer');
        // je linke le crud de ma classe Picture et autorise les modifications sur cette classe uniquement pour le rôle admin.
        // les autres rôles ne verront pas les liens dans la sidebar
        yield MenuItem::linkToCrud('Images', 'fas fa-solid fa-image', Picture::class)->setPermission('ROLE_ADMIN');
       
    }
    /**
     * Personalize Admin Css
     * https://symfony.com/bundles/EasyAdminBundle/current/design.html#customizing-the-backend-design
     */
    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('assets/css/admin.css');
    }

}
