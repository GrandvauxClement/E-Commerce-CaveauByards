<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
           IdField::new('id','ID')->onlyOnIndex(),
           EmailField::new('email','e-mail'),
           TextField::new('nom','Nom'),
           TextField::new('prenom','Prenom'),
           ChoiceField::new('civilite','Civilité')->setChoices(['Mr.'=>'Mr','Mme.'=>'Mme','Autre'=>'Autre']),
           DateField::new('dateNaissance','Date de Naissance'),
           AssociationField::new('adresseLivraisons','Adresse Livraison'),

        ];
    }

}
