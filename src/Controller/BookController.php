<?php

namespace App\Controller;

use App\Form\AdminBookType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    /**
     * @Route("/book", name="app_book")
     */
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }


     /**
     * @Route("/admin/livres/nouveau", name="app_book_create")
     */
    public function create(Request $request , BookRepository $repository): Response
    {
        //création du formulaire je n'ai pas besoin d'ajouter un objet Book en paramétre car je ne fait pas de préremplissage
        $form= $this->createForm(AdminBookType::class);
        //remplir le formulaire avec les données envoyées par l'utilisateur
        $form->handleRequest($request);


        //tester si le formulaire a était envoyé et est valide
        if ($form->isSubmitted() && $form->isValid()){

            //récupérer les données du formulaire dans un objet book
            $book= $form->getData();

            //enregistrer le livre dans la bd grace au repository
            $repository->add($book, true);

            //redirection de l'utilisateur vers la liste des livres
            return $this->redirectToRoute('app_book_list');
        }
        return $this->render('book/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }




     /**
     * @Route("/admin/livres", name="app_book_list")
     */
    public function list(BookRepository $repository): Response
    {

        //recuperer les livres depuis la bd
        $books= $repository->findAll(); //retourne la liste compléte des livres

        return $this->render('book/list.html.twig', [
            'books' => $books,
        ] );

    }

}
