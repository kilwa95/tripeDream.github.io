<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;


     /**
     * @ORM\Column(type="string", length=255,unique=true,nullable=true)
     */
    private $username;


    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $siret;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="users")
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=Avis::class, mappedBy="user")
     */
    private $avis;

    /**
     * @ORM\OneToMany(targetEntity=Favorie::class, mappedBy="user")
     */
    private $favorie;

    /**
     * @ORM\OneToMany(targetEntity=Voyage::class, mappedBy="user")
     */
    private $trips;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
        $this->favorie = new ArrayCollection();
        $this->trips = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    } 
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getSiret(): ?int
    {
        return $this->siret;
    }

    public function setSiret(?int $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|Avis[]
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setUser($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getUser() === $this) {
                $avi->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Favorie[]
     */
    public function getFavorie(): Collection
    {
        return $this->favorie;
    }

    public function addFavorie(Favorie $favorie): self
    {
        if (!$this->favorie->contains($favorie)) {
            $this->favorie[] = $favorie;
            $favorie->setUser($this);
        }

        return $this;
    }

    public function removeFavorie(Favorie $favorie): self
    {
        if ($this->favorie->removeElement($favorie)) {
            // set the owning side to null (unless already changed)
            if ($favorie->getUser() === $this) {
                $favorie->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Voyage[]
     */
    public function getTrips(): Collection
    {
        return $this->trips;
    }

    public function addTrip(Voyage $trip): self
    {
        if (!$this->trips->contains($trip)) {
            $this->trips[] = $trip;
            $trip->setUser($this);
        }

        return $this;
    }

    public function removeTrip(Voyage $trip): self
    {
        if ($this->trips->removeElement($trip)) {
            // set the owning side to null (unless already changed)
            if ($trip->getUser() === $this) {
                $trip->setUser(null);
            }
        }

        return $this;
    }
}
