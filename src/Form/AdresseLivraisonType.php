<?php

namespace App\Form;

use App\Entity\AdresseLivraison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseLivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('civilite', ChoiceType::class,[
                'required'=>true,
                'choices'  => [
                    'Mr' => 'Mr',
                    'Mme' => 'Mme',
                    'Autre' => 'Autre',
                ],
                'help' => 'Sélectionnez votre sexe',
            ])

            ->add('societe')
            ->add('adresse')
            ->add('adresseSuite')
            ->add('codePostal')
            ->add('Ville')
            ->add('telFix')
            ->add('telMobile')
            ->add('informationsSupp')
            ->add('titre')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdresseLivraison::class,
        ]);
    }
}
