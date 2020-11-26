<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(ProduitRepository $produitRepository,CategorieRepository $categorieRepository ): Response
    {
        $produit = $produitRepository->findAll();
        $Allcategories = $categorieRepository->findAll();
        return $this->render('site_Front/home.html.twig', [
            'controller_name' => 'DashboardController',
            'produits'=> $produit,
            'categories'=>$Allcategories
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function ContactViewAndSendEmail(CategorieRepository $categorieRepository ): Response
    {
        $Allcategories = $categorieRepository->findAll();
        return $this->render('site_Front/contact.html.twig', [
            'categories'=>$Allcategories
        ]);
    }

    /**
     * @Route("/presentation", name="presentation")
     */
    public function PresentationCaveau(CategorieRepository $categorieRepository ): Response
    {
        $Allcategories = $categorieRepository->findAll();
        return $this->render('site_Front/presentation.html.twig', [
            'categories'=>$Allcategories
        ]);
    }

    /**
     * @Route("/{categorie}", name="produitByCat", requirements={"categorie":"\d+"})
     */
    public function GetProduitByCat(ProduitRepository $produitRepository, CategorieRepository $categorieRepository, Categorie $categorie ): Response
    {
        $produit = $produitRepository->findByCategorie($categorie->getId());
        $Allcategories = $categorieRepository->findAll();
        return $this->render('site_Front/produitByCategorie.html.twig', [
            'controller_name' => 'DashboardController',
            'produits'=> $produit,
            'categories'=>$Allcategories,
            'categorieActive'=>$categorie
        ]);
    }

    /**
     * @Route("/{categorie}/{produit}", name="produitDetail", requirements={"produit":"\d+"})
     */
    public function GetProduitDetail(ProduitRepository $produitRepository, CategorieRepository $categorieRepository, Produit $produit ): Response
    {
        $allProduit = $produitRepository->findAll();
        $Allcategories = $categorieRepository->findAll();
        return $this->render('site_Front/detailProduit.html.twig', [
            'allProduits' => $allProduit,
            'produit'=> $produit,
            'categories'=>$Allcategories
        ]);
    }


}
