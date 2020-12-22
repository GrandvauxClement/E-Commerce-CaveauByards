<?php

namespace App\Controller\MonCompte;

use App\Entity\Order;
use App\Repository\CategorieRepository;
use App\Repository\OrderDetailsRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Services\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/moncompte")
 */
class CommandeController extends AbstractController
{
    protected $panierService;
    protected $categorieRepository;
    protected $AllCategories;
    protected $panierWithData;
    protected $totalPrice;
    protected $userRepository;
    private $orderRepository;
    private $orderDetailsRepository;
    public function __construct(PanierService $panierService, CategorieRepository $categorieRepository, UserRepository $userRepository, OrderRepository $orderRepository, OrderDetailsRepository $orderDetailsRepository)
    {
        $this->panierService = $panierService;
        $this->categorieRepository = $categorieRepository;
        $this->AllCategories = $categorieRepository->findAll();
        $this->panierWithData = $this->panierService->getDataPanier();
        $this->totalPrice = $this->panierService->getTotal($this->panierWithData);
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->orderDetailsRepository = $orderDetailsRepository;
    }
    /**
     * @Route("/MesCommande", name="mescommande")
     */
    public function index(OrderDetailsRepository $orderDetailsRepository): Response
    {
        $stockDetailOrders = [];
        $userUsername = $this->getUser()->getUsername();
        $userConnect = $this->userRepository->findBy(array('email'=> $userUsername));
        $orders = $this->orderRepository->findByUserId($userConnect[0]->getId());
        $ordersTest = $this->orderRepository->find(6);

        foreach ($orders as $value){
            $stockDetailOrders += [$value->getId()=>$orderDetailsRepository->findBy(['commande'=>$value->getId()])];
        }
        return $this->render('site_Front/monCompte/commandes/index.html.twig', [
            'categories'=>$this->AllCategories,
            'productInCart' => $this->panierWithData,
            'totalPrix'=> $this->totalPrice,
            'Orders'=>$orders,
            'ordersDetail'=>$stockDetailOrders,
        ]);
    }

    /**
     * @Route("/mesCommandes/addNewOrder/{id}", name="commande_add_panier")
     */
    public function addNewOrder(int $id){
        $order = $this->orderRepository->find($id);
        $orderDetailsAll = $this->orderDetailsRepository->findBy(['commande'=>$order->getId()]);
        foreach ($orderDetailsAll as $orderDetails){
            $idProduit = $orderDetails->getProduit()->getId();
            $quantity = $orderDetails->getQuantity();
            $this->panierService->add($idProduit, $quantity );
        }

        return $this->redirectToRoute('panier');
    }
}
