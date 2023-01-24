<?php

namespace App\Controller;

use App\Entity\Category;
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
        //tester si le formulaire a était envoyé
        if ($request->isMethod('POST')){

            //récupérer les données du formulaire
            $name= $request->request->get('name');

            //créer l'entité category à partir des données du formulaire
            $category= new Category();
            $category->setName($name);
           

            //enregistrer la category dans la bd grace au repository
            $repository->add($category, true);

            //redirection de l'utilisateur vers la liste des categories
            return $this->redirectToRoute('app_category_list');
        }
        return $this->render('category/create.html.twig', []);
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

        //tester si la formulaire est envoyé
        if($request->isMethod('POST')){
            
             //récupérer les données du formulaire
             $name= $request->request->get('name');

             //mise à jour des informations de la categorie
            $category->setName($name);
           

            //enregistrer la categorie
            $repository->add($category , true);

            //redirection vers la page de liste
            return $this->redirectToRoute('app_category_list');

        }
        return $this->render('category/update.html.twig', [ 'category' => $category] );
    }

     /**
     * @Route("/admin/categories/{id}/supprimer", name="app_category_remove")
     */
    public function remove(int $id, Request $request , CategoryRepository $repository): Response
    {
        //recuperer la categorie depuis son id
        $category = $repository->find($id);

        //suprimer la categorie de la base de données
        $repository->remove($category, true);

        //redirection vers la liste des categories
        return $this->redirectToRoute('app_category_list');
    }





}
