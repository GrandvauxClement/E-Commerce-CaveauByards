<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(ProduitRepository $produitRepository ): Response
    {
        $produit = $produitRepository->findAll();
        return $this->render('site_Front/home.html.twig', [
            'controller_name' => 'DashboardController',
            'produits'=> $produit
        ]);
    }
}
