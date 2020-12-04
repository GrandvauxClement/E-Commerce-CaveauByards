<?php
namespace App\Services;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService
{
    private $session;
    private $produitRepository;
    public function __construct(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $this->session = $session;
        $this->produitRepository = $produitRepository;
    }

    public function getDataPanier(){
        $panier = $this->session->get('panier', []);
        $panierWithData = [];
        foreach ( $panier as $id => $quantity) {
            $panierWithData[]= [
                'product'=>$this->produitRepository->find($id),
                'quantity'=>$quantity
            ];
        }
        return $panierWithData;
    }

    public function getTotal($panierWithData){
        $total =0;
        foreach ($panierWithData as $item){
            $toalItem = $item['product']->getPrix() * $item['quantity'];
            $total += $toalItem;
        }
        return $total;
    }

    public function add(int $id){
        $panier = $this->session->get('panier',[]);
        if (!empty($panier[$id])){
            $panier[$id]++;
        }
        else{
            $panier[$id] = 1;
        }
        $this->session->set('panier', $panier);
    }

    public function remove(int $id){
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])){
            unset($panier[$id]);
        }
        $this->session->set('panier', $panier);
    }
}