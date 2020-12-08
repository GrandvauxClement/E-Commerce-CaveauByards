<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Services\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, CategorieRepository $categorieRepository, PanierService $panierService): Response
    {
        if ($this->getUser()){
            if ($this->getUser()->getRoles()[0] == 'ROLE_ADMIN') {
                 return $this->redirectToRoute('admin');
             }
            else {
                return $this->redirectToRoute('dashboard');
            }
         }
        $panierWithData = $panierService->getDataPanier();
        $totalPrice = $panierService->getTotal($panierWithData);
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $Allcategories = $categorieRepository->findAll();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'categories'=>$Allcategories,
            'productInCart' => $panierWithData,
            'totalPrix'=> $totalPrice,
            ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
