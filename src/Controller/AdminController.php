<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function admin(): Response
    {
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin-add-films', name: 'admin-add_films')]
    #[IsGranted('ROLE_ADMIN')]
    public function adminAddFilms(): Response
    {
        return $this->render('admin/admin_add_films.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin-films', name: 'admin_films')]
    #[IsGranted('ROLE_ADMIN')]
    public function adminFilms(): Response
    {
        return $this->render('admin/admin_films.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin-users', name: 'admin_users')]
    #[IsGranted('ROLE_ADMIN')]
    public function adminUsers(): Response
    {
        return $this->render('admin/admin_films.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
