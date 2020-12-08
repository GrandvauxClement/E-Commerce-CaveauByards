<?php

namespace App\Controller;

use App\Form\QuantityProductType;
use App\Repository\AdresseLivraisonRepository;
use App\Repository\CategorieRepository;
use App\Repository\UserRepository;
use App\Services\PanierService;
use Symfony\Component\HttpFoundation\Request;
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
    public function index( CategorieRepository $categorieRepository, Request $request): Response
    {
        $allCategories = $categorieRepository->findAll();
        $panierWithData = $this->panierService->getDataPanier();
        $totalPrice = $this->panierService->getTotal($panierWithData);
       /* $form =$this->createForm(QuantityProductType::class,['id'=>$produit->getId()]);
        $form->handleRequest($request);*/
        if($request->getMethod()=="POST"){
            return $this->redirectToRoute('panier_add',['id'=>$_POST['id'],'quantity'=>$_POST['quantity']]);
        }
        return $this->render('site_Front/panier/index.html.twig', [
            'productInCart' => $panierWithData,
            'totalPrix'=> $totalPrice,
            'categories'=>$allCategories
        ]);
    }

    /**
     * @Route("/panier/add/{id}/{quantity}", name="panier_add")
     */
    public function add(int $id, int $quantity){

        $this->panierService->add($id, $quantity );
       return $this->redirectToRoute('panier');
    }

    /**
     * @Route("/panier/remove/{id}", name="panier_remove")
     */

    public function remove ($id){
        $this->panierService->remove($id);
        return $this->redirectToRoute('panier');
    }


    /**
     * @Route("/commande", name="commander")
     */
    public function Commande( CategorieRepository $categorieRepository, Request $request,
                              AdresseLivraisonRepository $adresseLivraisonRepository, UserRepository $userRepository): Response
    {
        $userUsername = $this->getUser()->getUsername();
        $userConnect = $userRepository->findBy(array('email'=> $userUsername));
        $allCategories = $categorieRepository->findAll();
        $panierWithData = $this->panierService->getDataPanier();
        $totalPrice = $this->panierService->getTotal($panierWithData);
        $adresseLivraison = $adresseLivraisonRepository->findBy(['user'=>$userConnect[0]->getId()]);


        return $this->render('site_Front/panier/commande.html.twig', [
            'productInCart' => $panierWithData,
            'totalPrix'=> $totalPrice,
            'categories'=>$allCategories,
            'adresseLivraison'=>$adresseLivraison,
        ]);
    }
}
