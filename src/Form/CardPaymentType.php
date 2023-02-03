<?php

namespace App\Form;

use App\DTO\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CardPaymentType extends AbstractType
{
        
    /**
     * buildForm
     *
     * @param  mixed $builder
     * @param  mixed $options
     * @return void
     * 
     * cardNumber => NumberType 
     * name => TextType
     * expiredDate => DateType
     * cvcNumber => NumberType
     * adress => TextType
     * all required 
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cardNumber', NumberType::class, [
                'label' => 'numéro de votre carte',
                'required' => true
            ])
            ->add('name', TextType::class, [    
                'label' => 'nom sur la carte',
                'required' => true
            ])
            ->add('expiredDate', DateType::class, [
                'widget' => 'single_text',
                'required' => true
            ])
            ->add('cvcNumber', NumberType::class, [
                'label' => 'numéro CVC',
                'required' => true
            ])
            ->add('adress', TextType::class, [
                'label' => 'votre adresse de facturation',
                'required' => true
            ])
            ->add('send', SubmitType::class,[
                'label' => 'Envoyer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
