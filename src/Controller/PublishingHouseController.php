<?php

namespace App\Controller;

use App\Form\AdminPublishingHouseType;
use App\Repository\PublishingHouseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublishingHouseController extends AbstractController
{
    /**
     * @Route("/publishing/house", name="app_publishing_house")
     */
    public function index(): Response
    {
        return $this->render('publishing_house/index.html.twig', [
            'controller_name' => 'PublishingHouseController',
        ]);
    }


     /**
     * @Route("/admin/maison-edition/nouveau", name="app_publishing_house_create")
     */
    public function create(Request $request , PublishingHouseRepository $repository): Response
    {
        //création du formulaire je n'ai pas besoin d'ajouter un objet PH en paramétre car je ne fait pas de préremplissage
        $form= $this->createForm(AdminPublishingHouseType::class);
        //remplir le formulaire avec les données envoyées par l'utilisateur
        $form->handleRequest($request);


        //tester si le formulaire a était envoyé et est valide
        if ($form->isSubmitted() && $form->isValid()){

            //récupérer les données du formulaire dans un objet PH
            $publishinghouse= $form->getData();

            //enregistrer la maison d'édition dans la bd grace au repository
            $repository->add($publishinghouse, true);

            //redirection de l'utilisateur vers la liste des maisons d'édition
            return $this->redirectToRoute('app_publishing_house_list');
        }
        return $this->render('publishing_house/create.html.twig', [
            'form' => $form->createView(), // génére le html du formulaire
        ]);
    }



     /**
     * @Route("/admin/maison-edition", name="app_publishing_house_list")
     */
    public function list(PublishingHouseRepository $repository): Response
    {

        //recuperer les maisons d'édition depuis la bd
        $publishinghouses= $repository->findAll(); //retourne la liste compléte des PH

        return $this->render('publishing_house/list.html.twig', [
            'publishinghouses' => $publishinghouses,
        ] );

    }


     /**
     * @Route("/admin/maison-edition/{id}", name="app_publishing_house_update")
     */
    public function update(int $id, Request $request, PublishingHouseRepository $repository): Response
    {
        //récuperer la PH de l'id
        $publishinghouse= $repository->find($id);

        //création du formulaire 
        $form= $this->createForm(AdminPublishingHouseType::class, $publishinghouse);
        //remplir le formulaire avec les données envoyées par l'utilisateur
        $form->handleRequest($request);

        //tester si le formulaire a était envoyé et est valide
        if ($form->isSubmitted() && $form->isValid()){

            //récupérer les données du formulaire dans un objet ph
            $publishinghouse= $form->getData();

            //enregistrer la maison d'édition dans la bd grace au repository
            $repository->add($publishinghouse, true);

            //redirection de l'utilisateur vers la liste des ph
            return $this->redirectToRoute('app_publishing_house_list');
        }
        return $this->render('publishing_house/update.html.twig', [
            'form' => $form->createView(),
            'publishinghouse' => $publishinghouse,
        ]);
    }


      /**
     * @Route("/admin/maison-edition/{id}/supprimer", name="app_publishing_house_remove")
     */
    public function remove(int $id , PublishingHouseRepository $repository): Response
    {
        //recuperer le livre depuis son id
        $ph = $repository->find($id);

        //suprimer le livre de la base de données
        $repository->remove($ph, true);

        //redirection vers la liste des categories
        return $this->redirectToRoute('app_publishing_house_list');
    }

}
