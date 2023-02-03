<?php

namespace App\Controller\Front;

use App\Entity\Book;
use App\Repository\BasketRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BasketController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
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
        return $this->redirectToRoute('app_front_home_home');
    }
}
