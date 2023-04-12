<?php

namespace App\Controller;

use App\DTO\Card;
use App\Entity\Book;
use App\Entity\Order;

use App\Form\CardPaymentType;

use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\BasketRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

            return $this->render('basket/display.html.twig', [
                'books' => $books,
                'totalPrice' => $basket->getTotal()
            ]);
        } else {
            return $this->redirectToRoute('app_login');
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

            $books = $basket->getBooks();

            return $this->render('basket/display.html.twig', [
                'books' => $books,
                'totalPrice' => $basket->getTotal()
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    /**
    * validate the basket 
    */
    #IsGranted('ROLE_USER')
    #[Route('/mon-panier/validation', name: 'app_basket_validate')]
    public function validate(Request $request, BasketRepository $basketRepository, UserRepository $userRepository, OrderRepository $orderRepository): Response
    {
        
        $user = $this->getUser();

        if ($user) {

            //Création du paiment
            $payment = new Card();

            // Récupere l'addresse de livraison
            $payment->address = $user->getDeliveryAddress();

            $basket = $user->getBasket();

            $books = $basket->getBooks();

            $form = $this->createForm(CardPaymentType::class, $payment);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                //créer la commande
                $order = new Order();

                // attacher la commande à l'utilisateur
                $order->setUser($user);

                foreach ($books as $book) {
                    //ajoute le livre à la commande
                    $order->addBook($book);

                    //supprimer le livre du panier
                    $basket->removeBook($book);
                }

                //ajouter l'addresse de livrasion à l'utilisateur
                $user->setDeliveryAddress($payment->address);

                $userRepository->add($user, true);
                $orderRepository->add($order, true);
                $basketRepository->add($basket, true);

                return new Response('Commande reçu avec succés');
            }

            return $this->render('basket/summary.html.twig', [
                'books' => $books,
                'totalPrice' => $basket->getTotal(),
                'cardPayment' => $form->createView(),
            ]);

        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
