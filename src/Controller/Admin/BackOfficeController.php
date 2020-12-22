<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Order;
use App\Entity\Produit;
use App\Entity\User;
use App\Repository\ProduitRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin")
 */

class BackOfficeController extends AbstractDashboardController
{
    /**
     * @Route("/index", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

      //  return $this->redirect($routeBuilder->setController(ProduitCrudController::class)->generateUrl());
       return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
           'user'=> 'mettreVAriable'
       ]);
    }

    /**
     * @Route("/apply_reduc", name="apply_reduc")
     */
    public function applyReduc(Request $request, ProduitRepository $produitRepository): Response
    {
        if ($request->getMethod() === 'POST'){
            $entityManager = $this->getDoctrine()->getManager();
            $allProduct = $produitRepository->findAll();
            foreach ( $allProduct as $product){
                $product->setReduction($_POST['pourcent']);
                $entityManager->persist($product);
            }
            $entityManager->flush();
            return $this->redirectToRoute('admin');
        }

        //  return $this->redirect($routeBuilder->setController(ProduitCrudController::class)->generateUrl());
        return $this->render('bundles/EasyAdminBundle/addReduc.html.twig', [
            'user'=> 'mettreVAriable'
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // the name visible to end users
            // you can include HTML contents too (e.g. to link to an image)
                ->setTitle('<h3> CAVEAU <span class="text-small">des byards</span></h3>')

            // the path defined in this method is passed to the Twig asset() function
            ->setFaviconPath('image/logo/logo_Caveau.jpg')

            // the domain used by default is 'messages'
            ->setTranslationDomain('my-custom-domain')

            // there's no need to define the "text direction" explicitly because
            // its default value is inferred dynamically from the user locale
            ->setTextDirection('ltr')

            // set this option if you prefer the page content to span the entire
            // browser width, instead of the default design which sets a max width
            ->renderContentMaximized()

            // set this option if you prefer the sidebar (which contains the main menu)
            // to be displayed as a narrow column instead of the default expanded design
            ->renderSidebarMinimized(false)
            ;
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Produit'),
            MenuItem::subMenu('Produit','fa fa-tags')->setSubItems([
                MenuItem::linkToCrud(' Mes Produits', 'fa fa-tags', Produit::class),
                MenuItem::linktoRoute('Appliquer une reduction','fa fa-tags','apply_reduc'),
            ]),

            MenuItem::section('Categorie'),
            MenuItem::linkToCrud('Catégorie', 'fa fa-comment', Categorie::class),

            MenuItem::section('Utilisateurs'),
            MenuItem::linkToCrud('Tous mes utilisateurs', 'fa fa-user', User::class),

            MenuItem::section('Commandes'),
            MenuItem::linkToCrud('Toutes les commandes','fas fa-shopping-cart',Order::class),

            MenuItem::section('Déconnexion'),
            MenuItem::linkToLogout('Se déconnecter', 'fa fa-sign-out'),
        ];
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            // this defines the pagination size for all CRUD controllers
            // (each CRUD controller can override this value if needed)
            ->setPaginatorPageSize(30)
            ->setNumberFormat('%.2d');

    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('css/admin.css');
    }
}
