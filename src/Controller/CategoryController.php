<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\AdminCategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="app_category")
     */
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }


     /**
     * @Route("/admin/categories/nouvelle", name="app_category_create")
     */
    public function create(Request $request , CategoryRepository $repository): Response
    {
       //création du formulaire je n'ai pas besoin d'ajouter un objet Category en paramétre car je ne fait pas de préremplissage
       $form= $this->createForm(AdminCategoryType::class);
       //remplir le formulaire avec les données envoyées par l'utilisateur
       $form->handleRequest($request);


       //tester si le formulaire a était envoyé et est valide
       if ($form->isSubmitted() && $form->isValid()){

           //récupérer les données du formulaire dans un objet category
           $category= $form->getData();

           //enregistrer l'auteur dans la bd grace au repository
           $repository->add($category, true);

           //redirection de l'utilisateur vers la liste des auteurs
           return $this->redirectToRoute('app_category_list');
       }
       return $this->render('category/create.html.twig', [
           'form' => $form->createView(),
       ]);
    }



     /**
     * @Route("/admin/categories", name="app_category_list")
     */
    public function list(CategoryRepository $repository): Response
    {

        //recuperer les auteurs depuis la bd
        $categories= $repository->findAll(); //retourne la liste compléte des auteurs

        return $this->render('category/list.html.twig', [
            'categories' => $categories,
        ] );

    }




    /**
     * @Route("/admin/categories/{id}", name="app_category_update")
     */
    public function update(int $id, Request $request , CategoryRepository $repository): Response
    {
        //recuperer la categorie à partir de l'id
        $category = $repository->find($id);

       //création du formulaire et son préremplissage
       $form= $this->createForm(AdminCategoryType::class, $category);

       //remplir le formulaire avec les données de l'utilisateur
       $form->handleRequest($request);

       //tester si la formulaire est envoyé et est valide
       if($form->isSubmitted() && $form->isValid()){
           
            //récupérer les données du formulaire dans un objet category
            $category = $form->getData();

           //enregistrer la category
           $repository->add($category , true);

           //redirection vers la page de liste
           return $this->redirectToRoute('app_category_list');
       }

        return $this->render('category/update.html.twig', [
            'form' => $form->createView(),
            'category' => $category ] );
    }

     /**
     * @Route("/admin/categories/{id}/supprimer", name="app_category_remove")
     */
    public function remove(int $id , CategoryRepository $repository): Response
    {
        //recuperer la categorie depuis son id
        $category = $repository->find($id);

        //suprimer la categorie de la base de données
        $repository->remove($category, true);

        //redirection vers la liste des categories
        return $this->redirectToRoute('app_category_list');
    }





}
