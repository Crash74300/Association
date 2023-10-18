<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('name',TextType::class,[
        'label'=> "Nom de l'administrateur",
                'attr' => [
                    'placeholder' => "Ce nom sera utiliser pour la connexion à l'application."
                ]
    ])
            ->add('email')
            ->add('password',RepeatedType::class,[
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
                'label'=> "Valider"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
