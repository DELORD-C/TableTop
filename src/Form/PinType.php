<?php

namespace App\Form;

use App\Entity\Pin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Nom', 'id' => 'pin-name'],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('note', TextType::class, [
                'label' => 'Note',
                'attr' => ['placeholder' => 'Note'],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('color', ChoiceType::class, [
                'label' => 'Couleur',
                'attr' => ['placeholder' => 'Couleur', 'id' => 'pin-color'],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ],
                'choices' => [
                    'Blanc' => 'white',
                    'Gris' => 'grey',
                    'Noir' => 'black',
                    'Jaune' => 'yellow',
                    'Marron' => 'brown',
                    'Orange' => 'orange',
                    'Rose' => 'pink',
                    'Rouge' => 'red',
                    'Violet' => 'purple',
                    'Bleu' => 'blue',
                    'Vert' => 'green',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pin::class
        ]);
    }
}