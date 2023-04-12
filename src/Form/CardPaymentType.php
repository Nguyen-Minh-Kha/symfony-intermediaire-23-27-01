<?php

namespace App\Form;

use App\DTO\Card;
use App\Form\AddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('cardNumber', TextType::class, [
                'label' => 'Numéro de carte bleu: ',
                'required' => true
            ])
            ->add('cardName', TextType::class, [
                'label' => 'Nom et prénom: ',
                'required' => true
            ])
            ->add('expirationDate', TextType::class, [
                'label' => 'Date d\'expiration: ',
                'required' => true
            ])
            ->add('cvc', TextType::class, [
                'label' => 'Code secret(CVC): ',
                'required' => true
            ])
            ->add('address', AddressType::class)

            ->add('send', SubmitType::class, [
                'label' => "Envoyer",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
