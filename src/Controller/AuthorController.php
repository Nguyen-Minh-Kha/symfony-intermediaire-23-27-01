<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author", name="app_author")
     */
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }


     /**
     * @Route("/admin/auteur/nouveau", name="app_author_create")
     */
    public function create(Request $request , AuthorRepository $repository): Response
    {
        //tester si le formulaire a était envoyé
        if ($request->isMethod('POST')){

            //récupérer les données du formulaire
            $name= $request->request->get('name');
            $description= $request->request->get('description');
            $imageUrl= $request->request->get('imageUrl');

            //créer l'entité auteur à partir des données du formulaire
            $author= new Author();
            $author->setName($name);
            $author->setDescription($description);
            $author->setImageUrl($imageUrl);

            //enregistrer l'auteur dans la bd grace au repository
            $repository->add($author, true);

            //redirection de l'utilisateur vers la liste des auteurs
            return $this->redirectToRoute('app_author_list');
        }
        return $this->render('author/create.html.twig', []);
    }




     /**
     * @Route("/admin/auteur", name="app_author_list")
     */
    public function list(AuthorRepository $repository): Response
    {

        //recuperer les auteurs depuis la bd
        $authors= $repository->findAll(); //retourne la liste compléte des auteurs

        return $this->render('author/list.html.twig', [
            'authors' => $authors,
        ] );

    }

}
