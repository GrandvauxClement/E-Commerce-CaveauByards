<?php

namespace App\Controller\MonCompte;

use App\Entity\AdresseLivraison;
use App\Form\AdresseLivraisonType;
use App\Repository\AdresseLivraisonRepository;
use App\Repository\CategorieRepository;
use App\Repository\UserRepository;
use App\Services\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/moncompte")
 */
class AdresseLivraisonController extends AbstractController
{
    protected $panierService;
    protected $categorieRepository;
    protected $AllCategories;
    protected $panierWithData;
    protected $totalPrice;
    protected $userRepository;
    public function __construct(PanierService $panierService, CategorieRepository $categorieRepository, UserRepository $userRepository)
    {
        $this->panierService = $panierService;
        $this->categorieRepository = $categorieRepository;
        $this->AllCategories = $categorieRepository->findAll();
        $this->panierWithData = $this->panierService->getDataPanier();
        $this->totalPrice = $this->panierService->getTotal($this->panierWithData);
        $this->userRepository = $userRepository;
    }
    /**
     * @Route("/mes_adresses", name="mes_adresses")
     */
    public function GetAllAdresse(AdresseLivraisonRepository $adresseLivraisonRepository): Response
    {
        $userUsername = $this->getUser()->getUsername();
        $userConnect = $this->userRepository->findBy(array('email'=> $userUsername));
        $adresseLivraison = $adresseLivraisonRepository->findBy(['user'=>$userConnect[0]->getId()]);
        return $this->render('site_Front/monCompte/adresses/allAdresses.html.twig', [
            'categories'=>$this->AllCategories,
            'productInCart' => $this->panierWithData,
            'totalPrix'=> $this->totalPrice,
            'allAdresses'=>$adresseLivraison

        ]);
    }

    /**
     * @Route("/addAdresseLivraison", name="addNewAdresseLivraison")
     */
    public function AddNewAdresseLivraison( UserRepository $userRepository, AdresseLivraisonRepository $adresseLivraisonRepository, Request $request): Response
    {
        $userUsername = $this->getUser()->getUsername();
        $userConnect = $userRepository->findBy(array('email'=> $userUsername));
        //  $adresseLivraison = $adresseLivraisonRepository->findBy(['user'=>$userConnect[0]->getId()]);

        $newAdress = new AdresseLivraison();

        $adressForm = $this->createForm(AdresseLivraisonType::class, $newAdress);
        $adressForm->handleRequest($request);
        if( $adressForm->isSubmitted() && $adressForm->isValid() ){
            $newAdress->setUser($userConnect[0]);
            $newAdress->setAdressePrincipal(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newAdress);
            $entityManager->flush();
            $this->redirectToRoute('commander');
        }


        return $this->render('site_Front/monCompte/adresses/addAdresseLivraison.html.twig', [
            'productInCart' => $this->panierWithData,
            'totalPrix'=> $this->totalPrice,
            'categories'=>$this->AllCategories,
            'adressForm'=>$adressForm->createView()
        ]);
    }


    /**
     * @Route("/adresses/{id}/edit", name="adresse_livraison_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AdresseLivraison $adresseLivraison): Response
    {
        $form = $this->createForm(AdresseLivraisonType::class, $adresseLivraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mes_adresses');
        }

        return $this->render('site_Front/monCompte/adresses/edit.html.twig', [
            'adresse_livraison' => $adresseLivraison,
            'productInCart' => $this->panierWithData,
            'totalPrix'=> $this->totalPrice,
            'categories'=>$this->AllCategories,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/deleteAdresse/{id}", name="adresse_livraison_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AdresseLivraison $adresseLivraison): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adresseLivraison->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adresseLivraison);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mes_adresses');
    }
}
