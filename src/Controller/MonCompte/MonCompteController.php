<?php

namespace App\Controller\MonCompte;

use App\Entity\AdresseLivraison;
use App\Form\AdresseLivraisonType;
use App\Form\RegistrationFormType;
use App\Repository\AdresseLivraisonRepository;
use App\Repository\CategorieRepository;
use App\Repository\UserRepository;
use App\Services\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonCompteController extends AbstractController
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
     * @Route("/moncompte", name="mon_compte")
     */
    public function index(): Response
    {
        return $this->render('site_Front/monCompte/monCompte.html.twig', [
            'categories'=>$this->AllCategories,
            'productInCart' => $this->panierWithData,
            'totalPrix'=> $this->totalPrice,
        ]);
    }

    /**
     * @Route("/moncompte/infoperso", name="mes_infos_perso")
     */
    public function GererInfoPerso(Request $request): Response
    {
        $userUsername = $this->getUser()->getUsername();
        $userConnect = $this->userRepository->findBy(array('email'=> $userUsername));

        $form = $this->createForm(RegistrationFormType::class, $userConnect[0]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


        }

        return $this->render('site_Front/monCompte/infoPerso.html.twig', [
            'registrationForm' => $form->createView(),
            'categories'=>$this->AllCategories,
            'productInCart'=>$this->panierWithData,
            'totalPrix'=>$this->totalPrice
        ]);
    }







}
