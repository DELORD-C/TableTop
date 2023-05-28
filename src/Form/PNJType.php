<?php

namespace App\Form;

use App\Entity\PNJ;
use App\Entity\Token;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PNJType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Nom'],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('PVM', IntegerType::class, [
                'label' => 'PVM',
                'attr' => ['placeholder' => 'PVM'],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('PV', IntegerType::class, [
                'label' => 'PV',
                'attr' => ['placeholder' => 'PV'],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('dmgDice', IntegerType::class, [
                'label' => 'Dégâts (D6)',
                'attr' => ['placeholder' => 'Dégâts (D6)'],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('dmgFixed', IntegerType::class, [
                'label' => 'Dégâts (fixes)',
                'attr' => ['placeholder' => 'Dégâts (fixes)'],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('speed', IntegerType::class, [
                'label' => 'Initiative',
                'attr' => ['placeholder' => 'Initiative'],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Note',
                'attr' => ['placeholder' => 'Note'],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ],
                'required' => false
            ])
            ->add('token', EntityType::class, [
                'class' => Token::class,
                'choice_label' => 'name',
                'label' => 'Token',
                'attr' => ['placeholder' => 'Token']
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PNJ::class
        ]);
    }
}