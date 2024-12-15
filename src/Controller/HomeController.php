<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MediaRepository $mediaRepository): Response
    {
        $medias = $mediaRepository->findPopular(maxResults: 9);
        return $this->render('index.html.twig', ['medias' => $medias]);
    }
}
