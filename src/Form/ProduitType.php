<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('reference')
            ->add('etat')
            ->add('description')
            ->add('prix')
            ->add('Annee')
            ->add('Cepage')
            ->add('ExpositionSoleil')
            ->add('MethodesVendanges')
            ->add('Veillissement')
            ->add('Vinification')
            ->add('ConseilDegustation')
            ->add('VolumeEnCl')
            ->add('Degre')
            ->add('Caracteristique')
            ->add('image')
            ->add('categorie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
