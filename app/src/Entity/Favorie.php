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
     * @ORM\Column(type="integer")
     */
    private $id_voyage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdVoyage(): ?int
    {
        return $this->id_voyage;
    }

    public function setIdVoyage(int $id_voyage): self
    {
        $this->id_voyage = $id_voyage;

        return $this;
    }
}
