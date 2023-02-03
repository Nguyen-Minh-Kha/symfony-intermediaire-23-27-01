<?php

namespace App\Controller\Front;

use App\Entity\Book;
use App\Repository\BasketRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @IsGranted("ROLE_USER")
* */
class BasketController extends AbstractController
{
    /**
     * 
     * @Route("/mon-panier/{id}/ajouter", name="app_front_basket_add")
     */
    public function add(Book $book, BasketRepository $repository): Response
    {
        //Récupérer le panier de l'utilisateur connécté.
        //récup l'utilisateur
        $user=$this->getUser();
        //recup du panier de cet utilisateur
        $basket= $user->getBasket();

        // Ajouter le livre correspondant à l'id dans le panier (eg: `$basket->addBook($book);`).
        $basket->addBook($book);


        //Enregistrer la panier dans la base de données.
        $repository ->add($basket , true);

        //Rediriger vers la page d'affichage du panier créé plus bas.
        return $this->redirectToRoute('app_front_basket_display');
    }


    /**
     * 
     * @Route("/mon-panier", name="app_front_basket_display")
     */
    public function display( BasketRepository $repository): Response
    {
        return $this->render('front/basket/display.html.twig');
    }


        /**
     * 
     * @Route("/mon-panier/{id}/supprimer", name="app_front_basket_remove")
     */
    public function remove(Book $book, BasketRepository $repository): Response
    {
        //Récupérer le panier de l'utilisateur connécté et supprimer le livre (eg: `$basket->removeBook($book)`).
        
        //récupérer l'utilisateur
        $user=$this->getUser();
        //récuprer la panier de l'utilisateur connecté
        $basket = $user->getBasket();
        //supprimer le livre du panier
        $basket->removeBook($book);

        //Enregistré le panier dans la base de données.
        $repository->add($basket , true);

        //Rediriger vers la page d'affichage du panier.
        return $this->redirectToRoute('app_front_basket_display');
    }
}
