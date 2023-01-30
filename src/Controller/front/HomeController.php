<?php

namespace App\Controller\front;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    #[Route('/front/results', name: 'app_home_home', methods: ['GET'])]
    public function home(BookRepository $bookRepository): Response
    {
         $books = $bookRepository->findAllOrderedByPrice();

         return $this->render('front/home/result.html.twig' , [
            'books' => $books
         ]);
    }

}
