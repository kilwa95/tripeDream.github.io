<?php

namespace App\Entity;

use App\Repository\TarifRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TarifRepository::class)
 */
class Tarif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="datetime")
     */
    private $depart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $retour;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacite;

    /**
     * @ORM\ManyToOne(targetEntity=Voyage::class, inversedBy="tarif")
     */
    private $voyage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDepart(): ?\DateTimeInterface
    {
        return $this->depart;
    }

    public function setDepart(\DateTimeInterface $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getRetour(): ?\DateTimeInterface
    {
        return $this->retour;
    }

    public function setRetour(\DateTimeInterface $retour): self
    {
        $this->retour = $retour;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getVoyage(): ?Voyage
    {
        return $this->voyage;
    }

    public function setVoyage(?Voyage $voyage): self
    {
        $this->voyage = $voyage;

        return $this;
    }

    public function __toString() {
        return "prix: ". $this->prix . " capacité: ". $this->capacite;
    }
//. "depart: ". $this->description;
}
