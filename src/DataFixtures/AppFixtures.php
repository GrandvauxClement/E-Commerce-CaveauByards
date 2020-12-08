<?php

namespace App\DataFixtures;

use App\Entity\AdresseLivraison;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Produit;
use App\Entity\Categorie;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder =$passwordEncoder;
    }

    public function load(ObjectManager $manager )
    {
        // Création d'un utilisateur Admin
        $admin = new User();
        $admin->setNom('admin');
        $admin->setPrenom('admin');
        $admin->setCivilite('Mr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setDateNaissance( new \DateTime('01/11/1997'));
        $admin->setEmail('admin@admin.com');
        $admin->setPassword(
            $this->passwordEncoder->encodePassword(
                $admin,
                'Admin123'
            )
        );
        $admin->setCodePostal('39210');
        $admin->setAdresse('admin');
        $admin->setVille('Le Vernois');
        $admin->setIsVerified(true);
        $manager->persist($admin);
        $manager->flush();

        // Création d'un utilisateur Test
        $userTest = new User();
        $userTest->setNom('clement');
        $userTest->setPrenom('Grandvaux');
        $userTest->setCivilite('Mr');
        $userTest->setDateNaissance( new \DateTime('06/12/2000'));
        $userTest->setRoles(['ROLE_USER']);
        $userTest->setEmail('clement.grandvaux@hotmail.com');
        $userTest->setPassword(
            $this->passwordEncoder->encodePassword(
                $userTest,
                'Admin123'
            )
        );
        $userTest->setCodePostal('39210');
        $userTest->setAdresse('354 chemin du pre chenole');
        $userTest->setVille('Le Vernois');
        $userTest->setIsVerified(true);
        $adresseUser = new AdresseLivraison();
        $adresseUser->setPrenom('simon');
        $adresseUser->setNom('Grandvaux');
        $adresseUser->setCivilte('Autre');
        $adresseUser->setAdresse('37 avenue de vizile');
        $adresseUser->setCodePostal('21000');
        $adresseUser->setVille('Dijon');
        $adresseUser->setInformationsSupp('2eme etage');
        $adresseUser->setTelMobile('06 29 16 89 43');
        $adresseUser->setTitre('Frangin');
        $manager->persist($adresseUser);
        $manager->flush();
        $userTest->addAdresseLivraison($adresseUser);
        $manager->persist($userTest);
        $manager->flush();

        // Definition de mes catégories
        $categorieUn = new Categorie();
        $categorieUn->setNom('côtes du jura');
        $categorieUn->setImage('cotes-du-jura');
        $manager->persist($categorieUn);
        $manager->flush();
        $categorieDeux = new Categorie();
        $categorieDeux->setNom('l\'etoile blanc');
        $categorieDeux->setImage('etoile-blanc');
        $manager->persist($categorieDeux);
        $manager->flush();
        $categorieTrois = new Categorie();
        $categorieTrois->setNom('crémants du jura');
        $categorieTrois->setImage('cremants-du-jura');
        $manager->persist($categorieTrois);
        $manager->flush();
        $categorieQuatre = new Categorie();
        $categorieQuatre->setNom('nos spécialités');
        $categorieQuatre->setImage('nos-specialtes');
        $manager->persist($categorieQuatre);
        $manager->flush();

        // Tous les vin issu de la catégorie Cotes du jura

         $product = new Produit();
         $product->setNom('Côtes du Jura Grande Réserve 2016');
         $product->setDescription('La puissance du Savagnin associée à l’élégance du Chardonnay assure un très bel équilibre à ce vin d’un très grand potentiel');
         $product->setEtat('Neuf');
         $product->setReference('CDJGDRES');
         $product->setPrix('12.00');
         $product->setImage('GrandeReserve2016');
         $product->setCategorie($categorieUn);
         $product->setAnnee('2016');
         $product->setCepage('Savagnin / Chardonnay');
         $product->setExpositionSoleil('Sud / Sud-Ouest');
         $product->setMethodesVendanges('Manuelles');
         $product->setVeillissement('Savagnin');
         $product->setVinification('Pressurage pneumatique. Thermorégulation des températures fermentatives. Vinification en volume raisonné pour optimiser l\'expression des cépages.; Caractéristique');
         $product->setConseilDegustation('Servir entre 15° et 16°. A déguster sur une viande blanche sauce à la crème et aux champignons des poissons une poêlée de Saint-Jacques un soufflé au Comté une crème mousseuse de châtaignes aux cèpes etc...');
         $product->setVolumeEnCl(75);
         $product->setDegre('14% Vol.');
         $manager->persist($product);
         $manager->flush();

        $product = new Produit();
        $product->setNom('Côtes du Jura Pinot Noir 2019');
        $product->setDescription('De belle couleur rubis avec des reflets ambrés, ce Pinot Noir offre un nez assez complexe. Son bouquet de fruits rouges saura ravir vos palais.');
        $product->setEtat('Neuf');
        $product->setReference('CDJPINOT');
        $product->setPrix('9.10');
        $product->setImage('PinotNoir2019');
        $product->setCategorie($categorieUn);
        $product->setAnnee('2019');
        $product->setCepage('Pinot noir');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('Elevé 6 à 12 mois en fûts de chêne.');
        $product->setVinification('Macération à froid puis fermentation à 23 - 25° avec remontages journaliers des jus. Pressurage pneumatique. Fermentation malolactique en foudres.; Caractéristique');
        $product->setConseilDegustation('Servir entre 14 et 16°. Ce vin au fort tempérament s\'accorderait bien avec un chevreuil une terrine ou un rôti. Peut également accompagner tout un repas.');
        $product->setVolumeEnCl(75);
        $product->setDegre('12.5% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Côtes du Jura Chardonnay 2018');
        $product->setDescription('Ce chardonnay, vieilli durant plus de 12 mois en fûts de chêne donne un vin franc et sec qui vous enchantera par ses arômes floraux et ses notes de fruits frais. A consommer en apéritif, avec du poisson ou encore des viandes blanches.');
        $product->setEtat('Neuf');
        $product->setReference('CDJCHARD');
        $product->setPrix('7.74');
        $product->setImage('Chardonnay2018');
        $product->setCategorie($categorieUn);
        $product->setAnnee('2018');
        $product->setCepage('Chardonnay');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('Elevé 18 mois en fûts de chêne');
        $product->setVinification('Pressurage pneumatique. Thermorégulation des températures fermentatives. Vinification en volume raisonné pour optimiser l\'expression du cépage.');
        $product->setConseilDegustation('Servir entre 13 et 15°. A déguster en apéritif avec une entrée poissons ou crustacés viandes blanches crémées comté.');
        $product->setCaracteristique('Jolie robe. Nez puissant. Arômes de noisettes. Vin riche. Ample et rond. Belle longueur en bouche. Vin à boire et pouvant attendre.');
        $product->setVolumeEnCl(75);
        $product->setDegre('13% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Côtes du Jura Trousseau 2019');
        $product->setDescription('Vin de garde, ce vin saura ravir vos papilles. Belle complexité aromatique aux reflets ambrés.');
        $product->setEtat('Neuf');
        $product->setReference('CDJTROUS');
        $product->setPrix('11.00');
        $product->setImage('Trousseau2019');
        $product->setCategorie($categorieUn);
        $product->setAnnee('2019');
        $product->setCepage('Trousseau');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('Elevé 6 à 12 mois en fûts de chêne.');
        $product->setVinification('Macération à froid puis fermentation à 23 - 25° avec r remontages journaliers des jus. Pressurage pneumatique. Fermentation malolactique en foudres.; Caractéristique');
        $product->setConseilDegustation('Servir entre 14 et 16°. Ce vin au fort tempérament s\'accorderait bien avec une terrine une viande rouge ou un gibier. Peut également accompagner tout un repas.');
        $product->setVolumeEnCl(75);
        $product->setDegre('12.5% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Côtes du Jura Perle de Rosé 2019');
        $product->setDescription('La Perle de Rosé est le rosé de vos étés. Issu d’une saignée de Pinot Noir, vous serez enchanter par ses arômes de fruits rouges.');
        $product->setEtat('Neuf');
        $product->setReference('CDJROSE');
        $product->setPrix('7.50');
        $product->setImage('PerleRose2019');
        $product->setCategorie($categorieUn);
        $product->setAnnee('2019');
        $product->setCepage('Pinot Noir');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('6 mois en cuves inox.');
        $product->setVinification('Macération à froid pendant 2 jours puis saignée sur cuve. Fermentation à basse température (environ 12 degrés) pendant 3 semaines. Fermentation malolactique en cuves inox.; Caractéristique');
        $product->setConseilDegustation('Servir entre 9 et 10°.  A boire rapidement Accompagnera à merveille les salades poissons et viandes grillées fruits de mer et crustacés etc...');
        $product->setVolumeEnCl(75);
        $product->setDegre('12.5% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Côtes du Jura Poulsard 2019');
        $product->setDescription('Vin du Jura légèrement rosé, aux arômes de fruits rouges. Accompagnera vos grillades et salades tout au long de l’année');
        $product->setEtat('Neuf');
        $product->setReference('CDJPOULS');
        $product->setPrix('9.10');
        $product->setImage('Poulsard2019');
        $product->setCategorie($categorieUn);
        $product->setAnnee('2019');
        $product->setCepage('Poulsard');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('pas besoin');
        $product->setVinification('Macération à froid puis fermentation à 23 - 25° avec remontages journaliers des jus. Pressurage pneumatique. Fermentation malolactique en foudres.; Caractéristique');
        $product->setConseilDegustation('	Servir légèrement frais. A déguster avec une terrine une viande blanche ou un rôti. Peut également accompagner tout un repas.');
        $product->setVolumeEnCl(75);
        $product->setDegre('12.5% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Côtes du Jura Savagnin 2016');
        $product->setDescription('Ce Savagnin, cépage unique au monde implanté dans le Jura sur des sols marneux, élevé pendant plusieurs années en pièce sous voile, vous dévoilera des arômes de noix et noisettes.');
        $product->setEtat('Neuf');
        $product->setReference('CDJSAVAG');
        $product->setPrix('15.20');
        $product->setImage('Savagin2016');
        $product->setCategorie($categorieUn);
        $product->setAnnee('2016');
        $product->setCepage('Savagnin');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('Elevé 26 mois en fûts de chêne (228 litres) sous voile de levures afin d\'assurer le développement des caractères spécifiques.');
        $product->setVinification('Pressurage pneumatique. Thermorégulation des températures fermentatives. Vinification en volume raisonné pour optimiser l\'expression des cépages.; Caractéristique');
        $product->setConseilDegustation('Servir entre 15° et 16°. A déguster sur une viande blanche sauce à la crème et aux champignons des poissons une poêlée de Saint-Jacques un soufflé au Comté une crème mousseuse de châtaignes aux cèpes etc...');
        $product->setVolumeEnCl(75);
        $product->setDegre('14.5% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Côtes du Jura Rubis 2018');
        $product->setDescription('Cette cuvée, assemblage des trois cépages rouges du Jura (Pinot Noir, Poulsard et trousseau) donne des arômes de fruits rouges, de pruneaux et d’épices.');
        $product->setEtat('Neuf');
        $product->setReference('CDJRUBIS');
        $product->setPrix('9.10');
        $product->setImage('Rubis2018');
        $product->setCategorie($categorieUn);
        $product->setAnnee('2018');
        $product->setCepage('Poulsard / Pinot noir / Trousseau');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('Pas de vieillissement');
        $product->setVinification('Macération à froid puis fermentation à 23 - 25° avec remontages journaliers des jus. Pressurage pneumatique. Fermentation malolactique en foudres.; Caractéristique');
        $product->setConseilDegustation('Servir légèrement frais. A déguster avec une terrine viandes charcuteries et fromages. Peut également accompagner tout un repas.');
        $product->setVolumeEnCl(75);
        $product->setDegre('12.5% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Côtes du Jura Poulsard 2018 BIO');
        $product->setDescription('Issu d\'un mode de production respectueux de l\'homme et de l\'environnement, ce Poulsard vous séduira par son nez fruité.
        
                                            En bouche, l\'attaque est franche avec une finale fraiche et ronde.

                                            Il sera le parfait compagnon pour accompagner vos apéritifs à base de charcuterie ainsi que vos barbecues et vos grillades estivales.');
        $product->setEtat('Neuf');
        $product->setReference('CDJPOULSBIO');
        $product->setPrix('12.00');
        $product->setImage('Poulsard2018Bio');
        $product->setCategorie($categorieUn);
        $product->setAnnee('2018');
        $product->setCepage('Poulsard');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('Pas de vieillissement');
        $product->setVinification('Macération à froid puis fermentation à 23 - 25° avec remontages journaliers des jus. Pressurage pneumatique. Fermentation malolactique en foudres.');
        $product->setCaracteristique('BIO');
        $product->setConseilDegustation('a déguster sur des charcuteries et barbecues');
        $product->setVolumeEnCl(75);
        $product->setDegre('12.5% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Côtes du Jura Chardonnay 2016 Magnum');
        $product->setDescription('Ce chardonnay, vieilli durant plus de 12 mois en fûts de chêne donne un vin franc et sec qui vous enchantera par ses arômes floraux et ses notes de fruits frais. A consommer en apéritif, avec du poisson ou encore des viandes blanches.');
        $product->setEtat('Neuf');
        $product->setReference('CDJCHARDMG');
        $product->setPrix('20.00');
        $product->setImage('Chardonnay2016Magnum');
        $product->setCategorie($categorieUn);
        $product->setAnnee('2016');
        $product->setCepage('Chardonnay');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('Elevé 18 mois en fûts de chêne');
        $product->setVinification('Pressurage pneumatique. Thermorégulation des températures fermentatives. Vinification en volume raisonné pour optimiser l\'expression du cépage.');
        $product->setCaracteristique('Jolie robe. Nez puissant. Arômes de noisettes. Vin riche. Ample et rond. Belle longueur en bouche. Vin à boire et pouvant attendre.');
        $product->setConseilDegustation('Servir entre 13 et 15°. A déguster en apéritif avec une entrée poissons ou crustacés viandes blanches crémées comté.');
        $product->setVolumeEnCl(150);
        $product->setDegre('13% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Côtes du Jura Trousseau 2018 Magnum');
        $product->setDescription('Vin de garde, ce vin saura ravir vos papilles. Belle complexité aromatique aux reflets ambrés.');
        $product->setEtat('Neuf');
        $product->setReference('CDJTROUSMAG');
        $product->setPrix('20.00');
        $product->setImage('Trousseau2018Magnum');
        $product->setCategorie($categorieUn);
        $product->setAnnee('2018');
        $product->setCepage('Trousseau');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('Elevé 6 à 12 mois en fûts de chêne.');
        $product->setVinification('Macération à froid puis fermentation à 23 - 25° avec r remontages journaliers des jus. Pressurage pneumatique. Fermentation malolactique en foudres.; Caractéristique');
        $product->setConseilDegustation('Servir entre 14 et 16°. Ce vin au fort tempérament s\'accorderait bien avec une terrine une viande rouge ou un gibier. Peut également accompagner tout un repas.');
        $product->setVolumeEnCl(150);
        $product->setDegre('12.5% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Côtes du Jura Chardonnay 2017 Les Poirières');
        $product->setDescription('Ce chardonnay bâtonné en fûts, vieilli durant plus de 18 mois en fûts de chêne donne un vin aux arômes de fleurs, de fruits et de torréfaction. Sa bouche souple avec une belle longueur vous séduira. A consommer en apéritif, avec une entrée, du poisson en sauce ou encore des viandes blanches.');
        $product->setEtat('Neuf');
        $product->setReference('CDJCHARDPOIR');
        $product->setPrix('10.00');
        $product->setImage('Chardonnay2017Poiriere');
        $product->setCategorie($categorieUn);
        $product->setAnnee('2017');
        $product->setCepage('Chardonnay');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('	Elevé 18 mois en fûts de chêne');
        $product->setVinification('Pressurage pneumatique. Thermorégulation des températures fermentatives. Vinification en volume raisonné pour optimiser l\'expression du cépage.');
        $product->setCaracteristique('Bouche souple avec une belle longueur');
        $product->setConseilDegustation('Servir entre 10 et 14°. A déguster en apéritif ou sur des entrées');
        $product->setVolumeEnCl(75);
        $product->setDegre('13% Vol.');
        $manager->persist($product);
        $manager->flush();

        // Tous les vin issu de la catégorie Etoile Blanc

        $product = new Produit();
        $product->setNom('L\'Etoile Chardonnay 2018');
        $product->setDescription('La robe claire reflète une fraîcheur et un nez très complexe de miel, tilleul et autres fleurs blanches. Une belle attaque en bouche et une superbe intensité aromatique laissent une impression de grande garde.');
        $product->setEtat('Neuf');
        $product->setReference('ETOCHARD');
        $product->setPrix('8.6');
        $product->setImage('EtoileChardonnay2018');
        $product->setCategorie($categorieDeux);
        $product->setAnnee('2018');
        $product->setCepage('Chardonnay');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('Elevé entre 9 et 15 mois sous bois.');
        $product->setVinification('Pressurage pneumatique. Thermorégulation des températures fermentatives. Vinification en volume raisonné pour optimiser l\'expression des cépages.; Caractéristique');
        $product->setConseilDegustation('Servir entre 13° et 15°. Excellent sur une purée de céleri une viande blanche un poisson grillé etc...');
        $product->setVolumeEnCl(75);
        $product->setDegre('13% Vol.');
        $manager->persist($product);
        $manager->flush();

        // Tous les vin issu de la catégorie Crémants Jura

        $product = new Produit();
        $product->setNom('Crémant du Jura Blanc Brut');
        $product->setDescription('Elaboré à base de chardonnay, ses bulles d’une très grande finesse et sa fraicheur feront pétiller vos papilles.');
        $product->setEtat('Neuf');
        $product->setReference('CRTBRUT');
        $product->setPrix('8.8');
        $product->setImage('CremantJuraBlancBrut');
        $product->setCategorie($categorieTrois);
        //$product->setAnnee('2018');
        $product->setCepage('Chardonnay');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('12 à 18 mois sur lattes pour un développement aromatique optimal.');
        $product->setVinification('Pressurage fractionné pour l\'obtention de cuvées. Prise de mousse à basses températures pour la finesse des bulles. Remuage et dégorgement avant habillage et commercialisation.; Caractéristique');
        $product->setConseilDegustation('Servir très frais en apéritif ou au dessert également à partager entre amis à toute heure de la journée.');
        $product->setVolumeEnCl(75);
        $product->setDegre('12% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Crémant du Jura Blanc Demi-sec');
        $product->setDescription('Elaboré à base de chardonnay, ses bulles d’une très grande finesse et sa fraicheur feront pétiller vos papilles.');
        $product->setEtat('Neuf');
        $product->setReference('CRTDSEC');
        $product->setPrix('8.8');
        $product->setImage('CremantJuraBlancDemiSec');
        $product->setCategorie($categorieTrois);
        //$product->setAnnee('2018');
        $product->setCepage('Chardonnay');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('12 à 18 mois sur lattes pour un développement aromatique optimal.');
        $product->setVinification('Pressurage fractionné pour l\'obtention de cuvées. Prise de mousse à basses températures pour la finesse des bulles. Remuage et dégorgement avant habillage et commercialisation.; Caractéristique');
        $product->setConseilDegustation('Servir très frais en apéritif ou au dessert également à partager entre amis à toute heure de la journée.');
        $product->setVolumeEnCl(75);
        $product->setDegre('12% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Crémant du Jura Blanc Demi-sec');
        $product->setDescription('Elaboré à base de chardonnay, ses bulles d’une très grande finesse et sa fraicheur feront pétiller vos papilles.');
        $product->setEtat('Neuf');
        $product->setReference('CRTDSEC');
        $product->setPrix('8.8');
        $product->setImage('CremantJuraBlancDemiSec');
        $product->setCategorie($categorieTrois);
        //$product->setAnnee('2018');
        $product->setCepage('Chardonnay');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('12 à 18 mois sur lattes pour un développement aromatique optimal.');
        $product->setVinification('Pressurage fractionné pour l\'obtention de cuvées. Prise de mousse à basses températures pour la finesse des bulles. Remuage et dégorgement avant habillage et commercialisation.; Caractéristique');
        $product->setConseilDegustation('Servir très frais en apéritif ou au dessert également à partager entre amis à toute heure de la journée.');
        $product->setVolumeEnCl(75);
        $product->setDegre('12% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Crémant du Jura Rosé Brut');
        $product->setDescription('Elaboré à base de Pinot Noir, Poulsard et Trousseau, ses bulles d’une très grande finesse et sa fraicheur feront pétiller vos papilles.');
        $product->setEtat('Neuf');
        $product->setReference('CRTROSE');
        $product->setPrix('9.30');
        $product->setImage('CremantJuraRoseBrut');
        $product->setCategorie($categorieTrois);
        //$product->setAnnee('2018');
        $product->setCepage('Poulsard / Pinot noir / Trousseau');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('12 à 18 mois sur lattes pour un développement aromatique optimal.');
        $product->setVinification('Pressurage fractionné pour l\'obtention de cuvées. Prise de mousse à basses températures pour la finesse des bulles. Remuage et dégorgement avant habillage et commercialisation.; Caractéristique');
        $product->setConseilDegustation('Servir très frais en apéritif ou au dessert également à partager entre amis à toute heure de la journée.');
        $product->setVolumeEnCl(75);
        $product->setDegre('12% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Crémant du Jura Blanc Brut "Cuvée Prestige"');
        $product->setDescription('Effervescence subtile, bulles fines et délicates, nez flatteur aux arômes floraux et fruités.');
        $product->setEtat('Neuf');
        $product->setReference('CRTPREST');
        $product->setPrix('13.50');
        $product->setImage('CremantJuraBlancPrestige');
        $product->setCategorie($categorieTrois);
        //$product->setAnnee('2018');
        $product->setCepage('Chardonnay 80% / Pinot noir 20%');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('18 mois minimum sur lattes pour un développement aromatique optimal');
        $product->setVinification('Pressurage fractionné pour l\'obtention de cuvées. Prise de mousse à basses températures pour la finesse des bulles. Remuage et dégorgement avant habillage et commercialisation.; Caractéristique');
        $product->setConseilDegustation('Servir très frais en apéritif ou au dessert également à partager entre amis à toute heure de la journée.');
        $product->setVolumeEnCl(75);
        $product->setDegre('12% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Crémant du Jura Blanc de Noirs Brut');
        $product->setDescription('Ce crémant, élaboré à base de Pinot Noir, au nez expressif privilégiant le fruit, présente une bouche gourmande aux arômes fruités mis en valeur par sa fraîcheur.');
        $product->setEtat('Neuf');
        $product->setReference('CRTBDN');
        $product->setPrix('10.40');
        $product->setImage('CremantJuraBlancNoirBrut');
        $product->setCategorie($categorieTrois);
        //$product->setAnnee('2018');
        $product->setCepage('Pinot noir');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('18 mois minimum sur lattes pour un développement aromatique optimal.');
        $product->setVinification('Prise de mousse à basses températures');
        $product->setConseilDegustation('Servir très frais en apéritif ou au dessert également à partager entre amis à toute heure de la journée.');
        $product->setVolumeEnCl(75);
        $product->setDegre('12% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Crémant du Jura Blanc Brut Magnum');
        $product->setDescription('Elaboré à base de chardonnay, ses bulles d’une très grande finesse et sa fraicheur feront pétiller vos papilles.');
        $product->setEtat('Neuf');
        $product->setReference('CRTBRUTMG');
        $product->setPrix('20.00');
        $product->setImage('CremantJuraBlancBrutMagnum');
        $product->setCategorie($categorieTrois);
        //$product->setAnnee('2018');
        $product->setCepage('Chardonnay');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('12 à 18 mois sur lattes pour un développement aromatique optimal.');
        $product->setVinification('Pressurage fractionné pour l\'obtention de cuvées. Prise de mousse à basses températures pour la finesse des bulles. Remuage et dégorgement avant habillage et commercialisation.; Caractéristique');
        $product->setConseilDegustation('Servir très frais en apéritif ou au dessert également à partager entre amis à toute heure de la journée.');
        $product->setVolumeEnCl(150);
        $product->setDegre('12% Vol.');
        $manager->persist($product);
        $manager->flush();

        // Tous les vin issu de la catégorie Nos Spécialités

        $product = new Produit();
        $product->setNom('Côtes du Jura Vin Jaune 2013');
        $product->setDescription('Après plus de 6 années de vieillissement en fûts de chêne sous un voile de levures, ce Vin Jaune a su acquérir des arômes de noix, d’amandes grillées, d’épices…');
        $product->setEtat('Neuf');
        $product->setReference('CDJJAUNE');
        $product->setPrix('29.50');
        $product->setImage('VinJaune2013');
        $product->setCategorie($categorieQuatre);
        $product->setAnnee('2013');
        $product->setCepage('Savagnin');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('6 ans en fûts de chêne sans ouillage (vin de voile).');
        $product->setVinification('Pressurage pneumatique. Thermorégulation des températures fermentatives.');
        $product->setConseilDegustation('Il est conseillé de le déboucher au moins 1 heure avant de le servir. Chambré (15 16°) il accompagnera à ravir les charcuteries fumées les volailles et gibiers le coq au vin le fromage de comté.');
        $product->setVolumeEnCl(62);
        $product->setDegre('14.5% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Château-Chalon Vin Jaune 2013');
        $product->setDescription('Fleuron du vignoble jurassien, ce Château chalon naît d’un long élevage sous voile (6 ans) et développe des arômes typiques de noix, de curry et de safran.');
        $product->setEtat('Neuf');
        $product->setReference('CHCJAUNE');
        $product->setPrix('32.50');
        $product->setImage('VinJauneChateauChalon2013');
        $product->setCategorie($categorieQuatre);
        $product->setAnnee('2013');
        $product->setCepage('Savagnin');
        $product->setExpositionSoleil('Sud / Sud-Ouest');
        $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('6 ans en fûts de chêne sans ouillage (vin de voile).');
        $product->setVinification('Pressurage pneumatique. Thermorégulation des températures fermentatives.');
        $product->setConseilDegustation('Il est conseillé de le déboucher au moins 1 heure avant de le servir. Chambré (15 16°) il accompagnera à ravir les charcuteries fumées les volailles et gibiers le coq au vin le fromage de comté.');
        $product->setVolumeEnCl(62);
        $product->setDegre('14.5% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Macvin du Jura Blanc');
        $product->setDescription('Subtil assemblage de moût de raisin et de marc, ce Macvin a vieilli plus de 18 mois en fûts de chêne. Ses arômes de miel, d’abricot et d’épices vous séduiront .');
        $product->setEtat('Neuf');
        $product->setReference('MACVIN');
        $product->setPrix('15.40');
        $product->setImage('MacvinJuraBlanc');
        $product->setCategorie($categorieQuatre);
       // $product->setAnnee('2013');
        $product->setCepage('Chardonnay');
       // $product->setExpositionSoleil('Sud / Sud-Ouest');
       // $product->setMethodesVendanges('Manuelles');
        $product->setVeillissement('Elevé 24 mois en fûts de chêne.');
        $product->setVinification('Pressurage pneumatique. Mutage du jus de raisin avant fermentation au vieux marc du Jura. Titre alcoométrique');
        $product->setConseilDegustation('A déguster sur de la glace à la vanille ou au miel avec une tarte tatin etc...');
        $product->setVolumeEnCl(75);
        $product->setDegre('17.5% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Côtes du Jura Vin de Paille 2016');
        $product->setDescription('Ce vin liquoreux est issu des cépages Chardonnay, Savagnin et poulsard. Les grappes sont naturellement desséchées à l’air libre , ce qui permet au sucre et aux arômes de se développer.');
        $product->setEtat('Neuf');
        $product->setReference('PAILLE');
        $product->setPrix('23.50');
        $product->setImage('VinPaille2016');
        $product->setCategorie($categorieQuatre);
         $product->setAnnee('2016');
        $product->setCepage('Chardonnay / Poulsard / Savagnin');
        // $product->setExpositionSoleil('Sud / Sud-Ouest');
         $product->setMethodesVendanges('Sélection rigoureuse des grappes les plus mûres et les plus saines.');
        $product->setVeillissement('En fûts de chêne pendant 3 ans.');
        $product->setVinification('Elaboration');
        $product->setConseilDegustation('Servir frais en apéritif. Accompagnera à ravir les foies gras tartes aux abricots entremets au chocolat...');
        $product->setVolumeEnCl(37);
        $product->setDegre('14.5% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('Vieux Marc du Jura');
        $product->setDescription('Vieilli en fûts de chêne pendant plusieurs années, ce Marc clôturera à merveille vos repas.');
        $product->setEtat('Neuf');
        $product->setReference('MARC');
        $product->setPrix('23.50');
        $product->setImage('VieuxMarc');
        $product->setCategorie($categorieQuatre);
       // $product->setAnnee('2016');
      //  $product->setCepage('Chardonnay / Poulsard / Savagnin');
        // $product->setExpositionSoleil('Sud / Sud-Ouest');
       // $product->setMethodesVendanges('Sélection rigoureuse des grappes les plus mûres et les plus saines.');
        $product->setVeillissement('Vieilli en fûts de chêne pendant plusieurs années.');
        $product->setVinification('Eau de vie distillée à partir de vin issu du pressurage de raisins provenant exclusivement de notre récolte.; Caractéristique');
        $product->setConseilDegustation('Jolie couleur ambrée nez flatteur boisé arômes d\'amandes et autres fruits secs. Beaucoup d\'élégance et de structure pour ce Marc fruité qui clôturera à merveille un bon repas entre amis.');
        $product->setVolumeEnCl(50);
        $product->setDegre('50% Vol.');
        $manager->persist($product);
        $manager->flush();

        $product = new Produit();
        $product->setNom('VERNOISINE Vin de liqueur rouge');
        $product->setDescription('Assemblage de moût de raisin rouge et d\'alcool, ce vin de liqueur vous séduira avec ses arômes de griottes, de cerises et de fruits rouges.');
        $product->setEtat('Neuf');
        $product->setReference('VERNOISINE');
        $product->setPrix('17.40');
        $product->setImage('Vernoisine');
        $product->setCategorie($categorieQuatre);
        // $product->setAnnee('2016');
        //  $product->setCepage('Chardonnay / Poulsard / Savagnin');
        // $product->setExpositionSoleil('Sud / Sud-Ouest');
        // $product->setMethodesVendanges('Sélection rigoureuse des grappes les plus mûres et les plus saines.');
        $product->setVeillissement('A Remplir');
        $product->setVinification('A remplir');
        $product->setConseilDegustation('A remplir');
        $product->setVolumeEnCl(75);
        $product->setDegre('12% Vol.');
        $manager->persist($product);
        $manager->flush();
    }
}
