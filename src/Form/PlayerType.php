<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Prénom'],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Nom'],
                'required' => false,
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
            'data_class' => Player::class,
            'attr' => [
                'class' => 'tinyForm'
            ]
        ]);
    }
}