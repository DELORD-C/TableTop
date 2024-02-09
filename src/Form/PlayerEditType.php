<?php

namespace App\Form;

use App\Entity\Player;
use App\Entity\Token;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Prénom'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'attr' => ['placeholder' => 'Nom'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('race', TextType::class, [
                'label' => 'Race',
                'attr' => ['placeholder' => 'Race'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('class', TextType::class, [
                'label' => 'Classe',
                'attr' => ['placeholder' => 'Classe'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('PVM', IntegerType::class, [
                'label' => 'PV Max',
                'attr' => ['placeholder' => 'PV Max'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('PV', IntegerType::class, [
                'label' => 'PV',
                'attr' => ['placeholder' => 'PV'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('PCM', IntegerType::class, [
                'label' => 'PC Max',
                'attr' => ['placeholder' => 'PC Max'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('PC', IntegerType::class, [
                'label' => 'PC',
                'attr' => ['placeholder' => 'PC'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('PMM', IntegerType::class, [
                'label' => 'PM Max',
                'attr' => ['placeholder' => 'PM Max'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('PM', IntegerType::class, [
                'label' => 'PM',
                'attr' => ['placeholder' => 'PM'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('PD', IntegerType::class, [
                'label' => 'PD',
                'attr' => ['placeholder' => 'PD'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('lvl', IntegerType::class, [
                'label' => 'Niveau',
                'attr' => ['placeholder' => 'Niveau'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('lore', TextAreaType::class, [
                'label' => 'Lore',
                'attr' => ['placeholder' => 'Lore'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('activ', TextAreaType::class, [
                'label' => 'Actifs',
                'attr' => ['placeholder' => 'Actifs'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('passiv', TextAreaType::class, [
                'label' => 'Passifs',
                'attr' => ['placeholder' => 'Passifs'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('dmgDice', IntegerType::class, [
                'label' => 'Dégâts (D6)',
                'attr' => ['placeholder' => 'Dégâts (D6)'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('dmgFixed', IntegerType::class, [
                'label' => 'Dégâts (fixes)',
                'attr' => ['placeholder' => 'Dégâts (fixes)'],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('strength', IntegerType::class, [
                'label' => 'Force',
                'attr' => [
                    'placeholder' => 'Force',
                    'min' => 0,
                    'max' => 100
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('intel', IntegerType::class, [
                'label' => 'Intelligence',
                'attr' => [
                    'placeholder' => 'Intelligence',
                    'min' => 0,
                    'max' => 100
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('social', IntegerType::class, [
                'label' => 'Social',
                'attr' => [
                    'placeholder' => 'Social',
                    'min' => 0,
                    'max' => 100
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('perception', IntegerType::class, [
                'label' => 'Perception',
                'attr' => [
                    'placeholder' => 'Perception',
                    'min' => 0,
                    'max' => 100
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('speed', IntegerType::class, [
                'label' => 'Initiative',
                'attr' => [
                    'placeholder' => 'Initiative',
                    'min' => 0,
                    'max' => 100
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
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
            'data_class' => Player::class,
        ]);
    }
}