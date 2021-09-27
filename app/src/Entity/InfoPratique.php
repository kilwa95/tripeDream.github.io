<?php

namespace App\Entity;

use App\Repository\InfoPratiqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InfoPratiqueRepository::class)
 */
class InfoPratique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $depart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $retour;

    /**
     * @ORM\Column(type="text")
     */
    private $hebergement;

    /**
     * @ORM\Column(type="text")
     */
    private $repas;

    /**
     * @ORM\Column(type="text")
     */
    private $covid19;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getHebergement(): ?string
    {
        return $this->hebergement;
    }

    public function setHebergement(string $hebergement): self
    {
        $this->hebergement = $hebergement;

        return $this;
    }

    public function getRepas(): ?string
    {
        return $this->repas;
    }

    public function setRepas(string $repas): self
    {
        $this->repas = $repas;

        return $this;
    }

    public function getCovid19(): ?string
    {
        return $this->covid19;
    }

    public function setCovid19(string $covid19): self
    {
        $this->covid19 = $covid19;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }
}
