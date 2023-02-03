<?php

namespace App\Controller\Front;

use App\DTO\Payment;
use App\Entity\Book;
use App\Entity\Order;
use App\Form\PaymentType;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\BasketRepository;
use Symfony\Component\HttpFoundation\Request;
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



    /**
     * 
     * @Route("/mon-panier/validation", name="app_front_basket_validate")
     */
    public function validate(Request $request, BasketRepository $repository, UserRepository $userrepo, OrderRepository $orderrepo): Response
    {

        //Création du paiment
        $payment= new Payment();

        //Récuperation de l'utilisateur connecté
        $user= $this->getUser();
        // Récupere l'addresse de livraison
        $payment->address = $user->getDeliveryAddress();

        //création du form de paiement
        $form = $this->createForm(PaymentType::class , $payment);

        // remplissage du form
        $form->handleRequest($request);

        //si le formulaire est envoyé et est valide
        if($form->isSubmitted() && $form->isValid()){

            //créer la commande
            $order= new Order();

            // attacher la commande à l'utilisateur
            $order->setUser($user);

            // pour chaque livre du panier
            foreach($user->getBasket()->getBooks() as $book){
                //ajoute le livre à la commande
                $order->addBook($book);

                //supprimer le livre du panier
                $user->getBasket()->removeBook($book);
            }


            //ajouter l'addresse de livrasion à l'utilisateur
            $user->setDeliveryAddress($payment->address);

            //sauvegarde des données
            $userrepo->add($user);
            $orderrepo->add($order);
            $repository->add($user->getBasket(), true);

            //redirection vers une page de détail
            return new Response('Commande reçu avec succés');
        }
        //affichage de la page de validation du panier
        return $this->render('front/basket/validate.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
