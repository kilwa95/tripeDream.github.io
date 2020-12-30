<?php

namespace App\Entity;

use App\Repository\FavorieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavorieRepository::class)
 */
class Favorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

   
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="favorie")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Voyage::class, inversedBy="favorie")
     */
    private $voyage;

    public function getId(): ?int
    {
        return $this->id;
    }

  

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
}
