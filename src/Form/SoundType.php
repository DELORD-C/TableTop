<?php

namespace App\Form;

use App\Entity\Sound;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SoundType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'attr' => [
                    'multiple' => 'multiple',
                    'accept' => 'audio/*'
                ],
                'multiple' => true,
                'mapped' => false
            ])
            ->add('icon', TextType::class, [
                'label' => 'Icône (Font Awesome)',
                'attr' => ['placeholder' => 'Icône (Font Awesome)'],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer',
                'row_attr' => [
                    'class' => 'd-grid gap-2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sound::class,
            'attr' => [
                'class' => 'tinyForm'
            ]
        ]);
    }
}