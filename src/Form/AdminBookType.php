<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label'=> 'Titre du livre',
                 'required'=> true   
            ])
            ->add('price', MoneyType::class,[
                'label'=> 'Prix du livre',
                 'required'=> true   
            ])
            ->add('description', TextareaType::class,[
                'label'=> 'Description du livre',
                 'required'=>  false     
            ])
            ->add('imageUrl', TextType::class,[
                'label'=> 'image du livre',
                 'required'=>  false     
            ])
            ->add('author', EntityType::class,[
                'label'=> 'Choix de l\'auteur',
                'required'=>  false,
                //spécifie l'entité que l'on veut pouvoir selectionner
                'class' => Author::class,
                //spécifie la propriéte de la classe Author que l'on veut afficher ici: author.name
                'choice_label' => 'name',

            ])
            ->add('categories', EntityType::class, [
                'label'=> 'Choix de la catégorie',
                'required'=>  false,
                //spécifie l'entité que l'on veut pouvoir selectionner
                'class' => Category::class,
                //spécifie la propriéte de la classe Category que l'on veut afficher ici: category.name
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])


            ->add('send', SubmitType::class, [
                'label' => "Envoyer",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
