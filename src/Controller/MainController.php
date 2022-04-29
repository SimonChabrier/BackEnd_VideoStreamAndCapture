<?php

namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MainController extends AbstractController
{

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="app_main")
     */
    public function index( ): Response
    {       
        // si il y a un user et qu'il est déjà identifié
        // https://symfony.com/doc/current/controller.html#redirecting
        if($this->getUser() && 'IS_AUTHENTICATED_FULLY'){
            return $this->redirectToRoute('app_admin');
        };
        // sinon :
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);

    }
}
