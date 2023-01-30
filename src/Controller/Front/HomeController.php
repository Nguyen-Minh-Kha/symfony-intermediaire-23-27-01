<?php

namespace App\Controller\Front;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/front/home", name="app_front_home_home")
     */
    public function home(BookRepository $repository): Response
    {
        // récupere la liste des livres selon la fonction qu'on a déclaré
        $books= $repository->findAllOrderedByPrice();

        //affichage de la page d'accueil
        return $this->render('front/home/home.html.twig', [
            'books' => $books,
        ]);
    }
}
