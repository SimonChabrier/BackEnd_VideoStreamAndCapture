<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // si il y a un user et qu'il est déjà identifié
        if($this->getUser() && 'IS_AUTHENTICATED_FULLY' && 'ROLE_ADMIN'){
            return $this->redirectToRoute('app_admin');
        };

        // sinon :
        return $this->render
        (
            'security/login.html.twig', 
            ['last_username' => $lastUsername, 'error' => $error]
        );
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
