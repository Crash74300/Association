<?php

namespace App\Form;

use App\Entity\Communication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use function Symfony\Component\Clock\now;

class CommunicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description',TextareaType::class,[
                'label'=> 'Description de votre projet de communication',
                'attr'=> [
                    'placeholder' => 'Détail de votre projet de communication',
                ]
            ])
            ->add('date_start',DateType::class,[
                'label'=> 'Date du début de la publication souhaité',
                'format' => 'dd-MM-yyyy',
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+1),
                'placeholder' => [
                    'day' => 'Jour', 'month' => 'Mois', 'year' => 'Année',
                ],
            ])
            ->add('date_stop',DateType::class,[
                'label'=> 'Date de fin de la publication souhaité',
                'format' => 'dd-MM-yyyy',
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y')+1),
                'placeholder' => [
                'day' => 'Jour', 'month' => 'Mois', 'year' => 'Année',
                ],
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
