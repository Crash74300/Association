<?php

namespace App\Form;

use App\Entity\Membres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AddMembresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('adresse')
            ->add('role', ChoiceType::class, [
                'choices'  => [
                    'Président' => 'president',
                    'Secrétaire' => 'Secrétaire',
                    'Trésorier' => 'Trésorier',
                    'Membre' => 'Membre',
                    'Vice président' => 'Vice président',
                    'Vice secrétaire' => 'Vice secrétaire',
                    'Vice trésorier' => 'Vice trésorier',
                ],
            ])
->add('imageFile', VichImageType::class,[
    'label' => 'Photo de profil',
    'required'      => false,
    'allow_delete'  => false,
    'label_attr' => [
        'class' => 'form-label mt-4'
    ]
])
            ->add('submit', SubmitType::class,[
                'label' => 'Valider',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membres::class,
        ]);
    }
}
