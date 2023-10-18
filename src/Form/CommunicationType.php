<?php

namespace App\Form;

use App\Entity\Communication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CommunicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description',TextType::class,[
                'label'=> 'Description de votre projet de communication'
            ])
            ->add('imageFile1', VichImageType::class,[
                'label' => 'Image 1',
                'required'      => false,
                'allow_delete'  => false,
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('imageFile2', VichImageType::class,[
                'label' => 'Image 2',
                'required'      => false,
                'allow_delete'  => false,
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label'=> "Envoyer ma demande"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Communication::class,
        ]);
    }
}
