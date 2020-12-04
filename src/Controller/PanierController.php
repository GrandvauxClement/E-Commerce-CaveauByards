<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Services\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    protected $panierService;
    public function __construct(PanierService $panierService)
    {
        $this->panierService = $panierService;
    }

    /**
     * @Route("/panier", name="panier")
     */
    public function index( CategorieRepository $categorieRepository): Response
    {
        $allCategories = $categorieRepository->findAll();
        $panierWithData = $this->panierService->getDataPanier();
        $totalPrice = $this->panierService->getTotal($panierWithData);
        return $this->render('site_Front/panier/index.html.twig', [
            'productInCart' => $panierWithData,
            'totalPrix'=> $totalPrice,
            'categories'=>$allCategories,
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function add($id){
        $this->panierService->add($id);
       return $this->redirectToRoute('dashboard');
    }

    /**
     * @Route("/panier/remove/{id}", name="panier_remove")
     */

    public function remove ($id){
        $this->panierService->remove($id);
        return $this->redirectToRoute('panier');
    }
}
