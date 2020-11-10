<?php

namespace App\Entity;

use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 */
class Agence extends User
{
   /**
    * @ORM\Column(type="text")
    */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $SIREN;

    /**
     * @ORM\OneToMany(targetEntity=Voyage::class, mappedBy="agence")
     */
    private $voyage;

    public function __construct()
    {
        $this->voyage = new ArrayCollection();
    }


    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSIREN(): ?int
    {
        return $this->SIREN;
    }

    public function setSIREN(int $SIREN): self
    {
        $this->SIREN = $SIREN;

        return $this;
    }

    /**
     * @return Collection|Voyage[]
     */
    public function getVoyage(): Collection
    {
        return $this->voyage;
    }

    public function addVoyage(Voyage $voyage): self
    {
        if (!$this->voyage->contains($voyage)) {
            $this->voyage[] = $voyage;
            $voyage->setAgence($this);
        }

        return $this;
    }

    public function removeVoyage(Voyage $voyage): self
    {
        if ($this->voyage->removeElement($voyage)) {
            // set the owning side to null (unless already changed)
            if ($voyage->getAgence() === $this) {
                $voyage->setAgence(null);
            }
        }

        return $this;
    }
}
