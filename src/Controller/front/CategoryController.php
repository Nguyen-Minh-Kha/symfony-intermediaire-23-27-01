<?php

namespace App\Controller\front;

use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/front/category', name: 'app_front_category')]
    public function index(): Response
    {
        return $this->render('front/category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
    /**
     * get books by category 
     */
    #[Route('/front/category/{id}', name: 'app_front_category_display')]
    public function display(BookRepository $bookRepository, CategoryRepository $categoryRepository, int $id): Response
    {
        $category = $categoryRepository->find($id);
        $books = $bookRepository->findAllOrderedByCategory($id);
        return $this->render('front/category/display.html.twig', [
            'books' => $books,
            'category' => $category,
        ]);
    }
}
