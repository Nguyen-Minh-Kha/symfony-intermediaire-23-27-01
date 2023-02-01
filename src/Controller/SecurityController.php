<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_security_registration")
     */
    public function registration(UserRepository $repository, Request $request, UserPasswordHasherInterface $hasher): Response
    {

        //création du formulaire
        $form = $this->createForm(RegistrationType::class);

        //on rempli le form avec les données de l'utilisateur
        $form->handleRequest($request);

        //verification si le form est envoyé et est valide
        if($form->isSubmitted() && $form->isValid()){
            //récuperer les données de l'utilisateur
            $user= $form->getData();

            //crypter le mot de passe
            $cryptedPass= $hasher->hashPassword($user , $user->getPassword()); // c'est ici que le mdp ecrit en clair se transforme en hash
            $user->setPassword($cryptedPass);

            //Enregistrer l'utilisateur dans la base de données
            $repository->add($user, true);


            //redirection vers la page d'accueil
            return $this->redirectToRoute('app_front_home_home');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
