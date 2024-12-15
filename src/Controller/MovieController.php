<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Serie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route('/movie/{id}', name: 'page_detail_movie')]
    public function detailMovie(string $id, Movie $movie): Response
    {
        return $this->render('movie/detail.html.twig', ['movie' => $movie]);
    }

    #[Route('/serie/{id}', name: 'page_detail_serie')]
    public function detailSerie(string $id, Serie $serie): Response
    {
        dump($serie);
        return $this->render('movie/detail_serie.html.twig', ['serie' => $serie]);
    }
}
