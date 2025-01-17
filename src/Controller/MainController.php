<?php

// https://symfony.com/doc/current/controller.html#redirecting
namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MainController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="app_main")
     */
    public function home(): Response
    {       
        if($this->getUser() && 'IS_AUTHENTICATED_FULLY' && 'ROLE_ADMIN'){
            return $this->redirectToRoute('app_admin');
        };
        return $this->redirectToRoute('app_login');
    }
}
