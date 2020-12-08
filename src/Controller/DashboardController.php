<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Form\QuantityProductType;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Services\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    private $panierWithData = [];
    private $allCategories;
    private $totalPrix;
    public function __construct(PanierService $panierService, CategorieRepository $categorieRepository)
    {
        $this->panierWithData = $panierService->getDataPanier();
        $this->totalPrix = $panierService->getTotal($this->panierWithData);
        $this->allCategories = $categorieRepository->findAll();
    }

    /**
     * @Route("/", name="dashboard")
     */
    public function index(ProduitRepository $produitRepository,CategorieRepository $categorieRepository ): Response
    {
        $produit = $produitRepository->findAll();
        return $this->render('site_Front/home.html.twig', [
            'controller_name' => 'DashboardController',
            'produits'=> $produit,
            'categories'=>$this->allCategories,
            'productInCart'=>$this->panierWithData,
            'totalPrix'=>$this->totalPrix
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function ContactViewAndSendEmail(CategorieRepository $categorieRepository ): Response
    {
        return $this->render('site_Front/contact.html.twig', [
            'categories'=>$this->allCategories,
        ]);
    }

    /**
     * @Route("/presentation", name="presentation")
     */
    public function PresentationCaveau(CategorieRepository $categorieRepository ): Response
    {
        return $this->render('site_Front/presentation.html.twig', [
            'categories'=>$this->allCategories,
            'productInCart'=>$this->panierWithData,
            'totalPrix'=>$this->totalPrix
        ]);
    }

    /**
     * @Route("/{categorie}", name="produitByCat", requirements={"categorie":"\d+"})
     */
    public function GetProduitByCat(ProduitRepository $produitRepository, Categorie $categorie ): Response
    {
        $produit = $produitRepository->findByCategorie($categorie->getId());
        return $this->render('site_Front/produitByCategorie.html.twig', [
            'controller_name' => 'DashboardController',
            'produits'=> $produit,
            'categories'=>$this->allCategories,
            'categorieActive'=>$categorie,
            'productInCart'=>$this->panierWithData,
            'totalPrix'=>$this->totalPrix
        ]);
    }

    /**
     * @Route("/{categorie}/{produit}", name="produitDetail", requirements={"produit":"\d+"})
     */
    public function GetProduitDetail(ProduitRepository $produitRepository, Produit $produit, Request $request ): Response
    {
        $allProduit = $produitRepository->findAll();
        $form =$this->createForm(QuantityProductType::class,['id'=>$produit->getId()]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            var_dump($form->getData());

            return $this->redirectToRoute('panier_add',['id'=>$produit->getId(),'quantity'=>$form->getData()['quantity']]);
        }

        return $this->render('site_Front/detailProduit.html.twig', [
            'allProduits' => $allProduit,
            'produit'=> $produit,
            'categories'=>$this->allCategories,
            'productInCart'=>$this->panierWithData,
            'totalPrix'=>$this->totalPrix,
            'form'=>$form->createView()
        ]);
    }


}
