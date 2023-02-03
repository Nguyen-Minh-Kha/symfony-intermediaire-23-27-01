<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasketController extends AbstractController
{
    #[Route('/basket', name: 'app_basket')]
    public function index(): Response
    {
        return $this->render('basket/index.html.twig', [
            'controller_name' => 'BasketController',
        ]);
    }

    /**
     * add book into basket
     */
    #IsGranted('ROLE_USER')
    #[Route('/mon-panier/{id}/ajouter', name: 'app_basket_add')]
    public function add(BasketRepository $basketRepository, Book $book): Response
    {

        $basket = $this->getUser()->getBasket();

        $basket->addBook($book);

        $basketRepository->save($basket, true);

        return $this->redirectToRoute('app_basket_display');
    }

    /**
    * display the basket 
    */
    #IsGranted('ROLE_USER')
    #[Route('/mon-panier', name: 'app_basket_display')]
    public function display(): Response
    {
        $user = $this->getUser();

        if ($user) {

            $basket = $user->getBasket();

            $books = $basket->getBooks();

            // dd($books);

            $totalPrice = $basket->getTotal();

            return $this->render('basket/display.html.twig', [
                'books' => $books,
                'totalPrice' => $totalPrice
            ]);
        } else {
            dd('user not found');
        }
    }

    /**
    * remove book from basket 
    */
    #IsGranted('ROLE_USER')
    #[Route('/mon-panier/{id}/supprimer', name: 'app_basket_remove')]
    public function remove(BasketRepository $basketRepository, Book $book): Response
    {
        $user = $this->getUser();

        if ($user) {

            $basket = $user->getBasket();

            $basket->removeBook($book);

            $basketRepository->save($basket, true);

            $totalPrice = $basket->getTotal();

            $books = $basket->getBooks();

            return $this->render('basket/display.html.twig', [
                'books' => $books,
                'totalPrice' => $totalPrice
            ]);
        } else {
            dd('user not found');
        }
    }
}
