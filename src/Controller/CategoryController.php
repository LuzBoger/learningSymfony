<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{


    #[Route(path: '/category/{id}', name: 'page_category')]
    public function category(string $id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);
        $categories = $categoryRepository->findAll();
        dump($category);
        return $this->render('movie/category.html.twig', ['category' => $category, "categories" => $categories]);
    }

    #[Route(path: '/discover', name: 'page_discover')]
    public function discover(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('movie/discover.html.twig', ['categories' => $categories]);
    }
}
