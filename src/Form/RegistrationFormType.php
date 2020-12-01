<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'required'=> true,
                'attr' =>
                    [
                        'class' => 'form-control'
                    ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'attr' =>
                    [
                        'class' => 'form-control'
                    ],
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' =>
                    [
                        'class' => 'form-control'
                    ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('civilite', ChoiceType::class,[
                'required'=>true,
                'choices'  => [
                    'Mr.' => 'Mr.',
                    'Mme' => 'Mme.',
                    'Autre' => 'Autre',
                ],
                'help' => 'Sélectionnez votre sexe',
            ])
            ->add('nom',TextType::class,[
                'required'=>true,
                'help' => 'Extended address info',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre nom',
                    ]),
                    ]
            ])
            ->add('prenom', TextType::class,[
                'required'=>true,
            ] )
            ->add('adresse', TextType::class,[
                'required'=>true,
                'attr' =>
                    [
                        'class' => 'form-control'
                    ]
            ])
            ->add('codePostal', TextType::class,[
                'required'=>true,
                'attr' =>
                    [
                        'class' => 'form-control'
                    ]
            ])
            ->add('ville', TextType::class,[
                'required'=>true,
                'attr' =>
                    [
                        'class' => 'form-control'
                    ]
            ])
           ->add('dateNaissance', DateType::class,[
                // adds a class that can be selected in JavaScript
               'widget' => 'single_text',
               //'attr' => ['class' => 'js-datepicker'],
               //'html5' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
