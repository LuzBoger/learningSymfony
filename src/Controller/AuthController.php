<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('auth/login.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/register', name: 'app_register')]
    public function register(): Response
    {
        return $this->render('auth/register.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/reset', name: 'app_reset')]
    public function reset(): Response
    {
        return $this->render('auth/reset.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/forgot', name: 'app_reset')]
    public function forgot(): Response
    {
        return $this->render('auth/forgot.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/confirm', name: 'app_reset')]
    public function confirm(): Response
    {
        return $this->render('auth/confirm.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }
}
