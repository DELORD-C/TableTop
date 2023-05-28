<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
                'attr' => ['placeholder' => 'Nom d\'utilisateur'],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Mot de passe',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'max' => 4096,
                    ]),
                ],
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('game', TextType::class, [
                'label' => 'Nom de la partie',
                'attr' => ['placeholder' => 'Nom de la partie'],
                'mapped' => false,
                'row_attr' => [
                    'class' => 'form-floating mb-3',
                ]
            ])
            ->add('game_password', TextType::class, [
                'label' => 'Mot de passe de la partie',
                'attr' => ['placeholder' => 'Mot de passe de la partie'],
                'mapped' => false,
                'row_attr' => [
                    'class' => 'form-floating mb-3',
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
