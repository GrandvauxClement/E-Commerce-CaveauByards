<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonCompteController extends AbstractController
{
    /**
     * @Route("/moncompte", name="mon_compte")
     */
    public function index(CategorieRepository $categorieRepository): Response
    {
        $Allcategories = $categorieRepository->findAll();
        return $this->render('site_Front/monCompte/monCompte.html.twig', [
            'categories'=>$Allcategories,
        ]);
    }

    /**
     * @Route("/moncompte/infoperso", name="mes_infos_perso")
     */
    public function GererInfoPerso(CategorieRepository $categorieRepository, UserRepository $userRepository): Response
    {
        $Allcategories = $categorieRepository->findAll();
        $this->getUser();
        return $this->render('site_Front/monCompte/infoPerso.html.twig', [
            'categories'=>$Allcategories,

        ]);
    }

}
