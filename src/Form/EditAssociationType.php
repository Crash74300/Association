<?php

namespace App\Form;

use App\Entity\Association;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditAssociationType extends AbstractType
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
            ->add('submit', SubmitType::class,[
                'label'=> "Modifier l'association"
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
