<?php

namespace App\Controller;

use App\Repository\PlaylistRepository;
use App\Repository\PlaylistSubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ListController extends AbstractController
{
    #[Route('/lists', name: 'page_lists')]
    #[IsGranted('ROLE_USER')]
    public function index(PlaylistRepository $playlistRepository, PlaylistSubscriptionRepository $playlistSubscriptionRepository,): Response
    {
        $user = $this->getUser();

        // Rediriger si l'utilisateur n'est pas connecté
        if (!$user) {
            return $this->redirectToRoute('app_home'); // Remplacez 'app_homepage' par la route de la page d'accueil
        }


        $myPlaylists = $playlistRepository->findBy(['creator' => $user]);
        $mySubscribedPlaylists = $playlistSubscriptionRepository->findBy(['subscriber' => $user]);

        return $this->render('movie/lists.html.twig', [
            'myPlaylists' => $myPlaylists,
            'mySubscribedPlaylists' => $mySubscribedPlaylists,
        ]);
    }
}
