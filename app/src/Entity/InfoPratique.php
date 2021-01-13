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
    private $rendez_vous;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fin_sejour;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRendezVous(): ?\DateTimeInterface
    {
        return $this->rendez_vous;
    }

    public function setRendezVous(\DateTimeInterface $rendez_vous): self
    {
        $this->rendez_vous = $rendez_vous;

        return $this;
    }

    public function getFinSejour(): ?\DateTimeInterface
    {
        return $this->fin_sejour;
    }

    public function setFinSejour(\DateTimeInterface $fin_sejour): self
    {
        $this->fin_sejour = $fin_sejour;

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

    public function __toString()
    {
        return $this->repas;
    }
}
