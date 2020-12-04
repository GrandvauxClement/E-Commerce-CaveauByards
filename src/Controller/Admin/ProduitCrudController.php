<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id','ID')->onlyOnIndex(),
            TextField::new('nom'),
            NumberField::new('prix'),
            TextField::new('reference')->onlyOnForms(),
            TextField::new('etat')->onlyOnForms(),
            TextEditorField::new('description')->onlyOnForms(),
            AssociationField::new('categorie'),
            TextField::new('Annee'),
            TextField::new('Cepage'),
            TextField::new('ExpositionSoleil')->onlyOnForms(),
            TextField::new('MethodesVendanges')->onlyOnForms(),
            TextField::new('Veillissement')->onlyOnForms(),
            TextEditorField::new('Vinification')->onlyOnForms(),
            TextEditorField::new('ConseilDegustation')->onlyOnForms(),
            NumberField::new('VolumeEnCl','Volume en Cl')->onlyOnForms(),
            TextField::new('Degre')->onlyOnForms(),
            TextEditorField::new('Caracteristique')->onlyOnForms(),

        ];
    }

}
