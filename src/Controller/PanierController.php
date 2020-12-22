<?php

namespace App\Controller;

use App\Entity\AdresseLivraison;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\AdresseLivraisonType;
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
    private $panierService;
    private  $allCategories;
    private $panierWithData;
    private $totalPrice;

    public function __construct(PanierService $panierService, CategorieRepository $categorieRepository)
    {

        $this->panierService = $panierService;

        $this->allCategories = $categorieRepository->findAll();
        $this->panierWithData = $this->panierService->getDataPanier();
        $this->totalPrice = $this->panierService->getTotal($this->panierWithData);
    }

    /**
     * @Route("/panier", name="panier")
     */
    public function index( CategorieRepository $categorieRepository, Request $request): Response
    {
        if($request->getMethod()=="POST"){
            return $this->redirectToRoute('panier_add',['id'=>$_POST['id'],'quantity'=>$_POST['quantity']]);
        }
        return $this->render('site_Front/panier/index.html.twig', [
            'productInCart' => $this->panierWithData,
            'totalPrix'=> $this->totalPrice,
            'categories'=>$this->allCategories
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
    public function Commande(  Request $request, UserRepository $userRepository, AdresseLivraisonRepository $adresseLivraisonRepository): Response
    {
        $userUsername = $this->getUser()->getUsername();
        $userConnect = $userRepository->findBy(array('email'=> $userUsername));
        $adresseLivraison = $adresseLivraisonRepository->findBy(['user'=>$userConnect[0]->getId()]);

        if( $request->getMethod() == 'POST' ){
            $entityManager = $this->getDoctrine()->getManager();
            $order = new Order();
            $order->setAdresseLivraison($adresseLivraisonRepository->find($adresseLivraison[$_POST['adresse']-1]->getId()));
            $order->setPrix($this->totalPrice);
            $order->setCreationDate(new \DateTime());
            $order->setStatus('En cours de payement');
            $order->setUser($userConnect[0]);
            $entityManager->persist($order);
            $entityManager->flush();
            foreach ($this->panierWithData as $dataDetail){

                $orderDetail = new OrderDetails();
                $orderDetail->setQuantity($dataDetail['quantity']);
                $orderDetail->setProduit($dataDetail['product']);
                $orderDetail->setCommande($order);
                $entityManager->persist($orderDetail);
                $entityManager->flush();
            }
            return $this->redirectToRoute('interface_payment');
        }


        return $this->render('site_Front/panier/commande.html.twig', [
            'productInCart' => $this->panierWithData,
            'totalPrix'=> $this->totalPrice,
            'categories'=>$this->allCategories,
            'adresseLivraison'=>$adresseLivraison,
        ]);
    }

    /**
     * @Route("/commande/payment", name="interface_payment")
     */

    public function interfacePayment (){
        return $this->render('site_Front/panier/inerfacePayment.html.twig', [
            'productInCart' => $this->panierWithData,
            'totalPrix'=> $this->totalPrice,
            'categories'=>$this->allCategories,
        ]);
    }
}
