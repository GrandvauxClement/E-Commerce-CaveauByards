<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $etat;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="produit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $Annee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Cepage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ExpositionSoleil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $MethodesVendanges;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Veillissement;

    /**
     * @ORM\Column(type="text")
     */
    private $Vinification;

    /**
     * @ORM\Column(type="text")
     */
    private $ConseilDegustation;

    /**
     * @ORM\Column(type="integer")
     */
    private $VolumeEnCl;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Degre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Caracteristique;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getAnnee(): ?string
    {
        return $this->Annee;
    }

    public function setAnnee(string $Annee): self
    {
        $this->Annee = $Annee;

        return $this;
    }

    public function getCepage(): ?string
    {
        return $this->Cepage;
    }

    public function setCepage(string $Cepage): self
    {
        $this->Cepage = $Cepage;

        return $this;
    }

    public function getExpositionSoleil(): ?string
    {
        return $this->ExpositionSoleil;
    }

    public function setExpositionSoleil(string $ExpositionSoleil): self
    {
        $this->ExpositionSoleil = $ExpositionSoleil;

        return $this;
    }

    public function getMethodesVendanges(): ?string
    {
        return $this->MethodesVendanges;
    }

    public function setMethodesVendanges(string $MethodesVendanges): self
    {
        $this->MethodesVendanges = $MethodesVendanges;

        return $this;
    }

    public function getVeillissement(): ?string
    {
        return $this->Veillissement;
    }

    public function setVeillissement(string $Veillissement): self
    {
        $this->Veillissement = $Veillissement;

        return $this;
    }

    public function getVinification(): ?string
    {
        return $this->Vinification;
    }

    public function setVinification(string $Vinification): self
    {
        $this->Vinification = $Vinification;

        return $this;
    }

    public function getConseilDegustation(): ?string
    {
        return $this->ConseilDegustation;
    }

    public function setConseilDegustation(string $ConseilDegustation): self
    {
        $this->ConseilDegustation = $ConseilDegustation;

        return $this;
    }

    public function getVolumeEnCl(): ?int
    {
        return $this->VolumeEnCl;
    }

    public function setVolumeEnCl(int $VolumeEnCl): self
    {
        $this->VolumeEnCl = $VolumeEnCl;

        return $this;
    }

    public function getDegre(): ?string
    {
        return $this->Degre;
    }

    public function setDegre(string $Degre): self
    {
        $this->Degre = $Degre;

        return $this;
    }

    public function getCaracteristique(): ?string
    {
        return $this->Caracteristique;
    }

    public function setCaracteristique(?string $Caracteristique): self
    {
        $this->Caracteristique = $Caracteristique;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
