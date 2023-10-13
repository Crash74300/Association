<?php

namespace App\Form;

use App\Entity\Association;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddAssociationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => "Nom de l'association",
                'attr' => [
                    'placeholder' => "Nom",
                    ]
            ])
            ->add('email', TextType::class,[
                'label' => "Email de contact de l'association",
                'attr' => [
                    'placeholder' => "Email"
                ]
            ])
            ->add('phone', TextType::class,[
                'label' => "Téléphone de contact de l'association",
                'attr' => [
                    'placeholder' => "Téléphone"
                ]
            ])

            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique',
                'label' => 'Mot de passe',
                'required' => true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'attr'=> [
                    'placeholder' => 'Saisir un mot de passe'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label'=> "Créer l'association"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Association::class,
        ]);
    }
}
