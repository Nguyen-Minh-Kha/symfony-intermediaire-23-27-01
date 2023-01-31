<?php

namespace App\Form;


use App\Entity\Author;
use App\Entity\Category;
use App\DTO\SearchBookCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/* 
| nom        | type       | requis |
| ---------- | ---------- | ------ |
| title      | TextType   | false  |
| authors    | EntityType | false  |
| categories | EntityType | false  |
| minPrice   | MoneyType  | false  |
| maxPrice   | MoneyType  | false  |
 */

class SearchBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "titre du livre",
                'required' => false
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'label' => "auteurs du livre",
                'required' => false,
                'choice_label' => "name",
                'multiple' => true,
                'expanded' => true
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'label' => "catégories",
                'required' => false,
                'choice_label' => "name",
                'multiple' => true,
                'expanded' => true
            ])
            ->add('minPrice', MoneyType::class, [
                'label' => "Prix Minimum",
                'required' => false
            ])
            ->add('maxPrice', MoneyType::class, [
                'label' => "Prix Maximum",
                'required' => false
            ])
            ->add('send', SubmitType::class, [
                'label' => "Envoyer",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => SearchBookCriteria::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
