<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id','ID')->onlyOnIndex(),
            DateField::new('creationDate','Date de création'),
            AssociationField::new('user','Utilisateur'),
            NumberField::new('prix','Prix en €'),
            AssociationField::new('orderDetails','Detail des commandes'),
            TextField::new('status','Status'),
            AssociationField::new('adresseLivraison','Adresse de livraison'),
        ];
    }

}
