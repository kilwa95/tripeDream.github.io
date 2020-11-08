<?php

namespace App\Entity;

use App\Repository\AgenceRepository;
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
}
