<?php

namespace App\Controller\front;

use App\Form\SearchBookType;
use App\Repository\BookRepository;
use App\DTO\SearchBookCriteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/front/home', name: 'app_front_home')]
    public function index(): Response
    {
        return $this->render('front/home/index.html.twig', [
            'controller_name' => 'FrontHomeController',
        ]);
    }

    /**
     * ex1: show last 20 books by price 
     */
    #[Route('/front/results', name: 'app_front_home_home')]
    public function home(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAllOrderedByPrice();

        return $this->render('front/home/result.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * search for books
     */
    #[Route('/front/search', name: 'app_front_home_search', methods: ['GET', 'POST'])]
    public function search(Request $request, BookRepository $bookRepository, SearchBookCriteria $searchBookCriteria): Response
    {
        $form = $this->createForm(SearchBookType::class, $searchBookCriteria);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchBookCriteria = $form->getData();
            $books = $bookRepository->findByCriteria($searchBookCriteria);

            return $this->render('front/home/searchResults.html.twig', [
                'books' => $books,
            ]);
        }
        return $this->render('front/home/searchForm.html.twig', [
            'searchForm' => $form->createView(),
        ]);
    }
}
