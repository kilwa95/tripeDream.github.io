<?php

namespace App\Entity;

use App\Repository\VoyageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoyageRepository::class)
 * @Vich\Uploadable
 */
class Voyage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $pointFort;


    /**
     * @Vich\UploadableField(mapping="voyage_image", fileNameProperty="imageName",size="imageSize")
     * @var File|null
     */
    private $imageFile;


    /**
     * @ORM\Column(type="string")
     * @var string|null
     */
    private $imageName;


    /**
     * @ORM\Column(type="integer")
     * @var int|null
     */
    private $imageSize;


   /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

  
    /**
     * @ORM\OneToMany(targetEntity=Avis::class, mappedBy="voyage")
     */
    private $avis;

    /**
     * @ORM\ManyToMany(targetEntity=Ville::class, inversedBy="voyages")
     */
    private $ville;

    /**
     * @ORM\ManyToMany(targetEntity=Pays::class, inversedBy="voyages")
     */
    private $pays;

    /**
     * @ORM\ManyToMany(targetEntity=Activite::class, inversedBy="voyages")
     */
    private $activity;

    /**
     * @ORM\ManyToMany(targetEntity=Saison::class, inversedBy="voyages")
     */
    private $saison;

    /**
     * @ORM\OneToMany(targetEntity=Tarif::class, mappedBy="voyage",cascade={"persist"})
     */
    private $tarif;

    /**
     * @ORM\OneToMany(targetEntity=Programme::class, mappedBy="voyage",cascade={"persist"})
     */
    private $programme;

    /**
     * @ORM\OneToOne(targetEntity=InfoPratique::class, cascade={"persist", "remove"})
     */
    private $infoPratique;

    /**
     * @ORM\OneToMany(targetEntity=Favorie::class, mappedBy="voyage")
     */
    private $favorie;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="voyage")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Panier::class, mappedBy="voyage")
     */
    private $paniers;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="participat")
     */
    private $usersParticipat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="voyage")
     */
    private $orders;


 

    public function __construct()
    {
        $this->avis = new ArrayCollection();
        $this->ville = new ArrayCollection();
        $this->pays = new ArrayCollection();
        $this->activity = new ArrayCollection();
        $this->saison = new ArrayCollection();
        $this->tarif = new ArrayCollection();
        $this->programme = new ArrayCollection();
        $this->favorie = new ArrayCollection();
        $this->paniers = new ArrayCollection();
        $this->usersParticipat = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getPointFort(): ?string
    {
        return $this->pointFort;
    }

    public function setPointFort(?string $pointFort): self
    {
        $this->pointFort = $pointFort;

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
            $avi->setVoyage($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getVoyage() === $this) {
                $avi->setVoyage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ville[]
     */
    public function getVille(): Collection
    {
        return $this->ville;
    }

    public function addVille(Ville $ville): self
    {
        if (!$this->ville->contains($ville)) {
            $this->ville[] = $ville;
        }

        return $this;
    }

    public function removeVille(Ville $ville): self
    {
        $this->ville->removeElement($ville);

        return $this;
    }

    /**
     * @return Collection|Pays[]
     */
    public function getPays(): Collection
    {
        return $this->pays;
    }

    public function addPay(Pays $pay): self
    {
        if (!$this->pays->contains($pay)) {
            $this->pays[] = $pay;
        }

        return $this;
    }

    public function removePay(Pays $pay): self
    {
        $this->pays->removeElement($pay);

        return $this;
    }

    /**
     * @return Collection|Activite[]
     */
    public function getActivity(): Collection
    {
        return $this->activity;
    }

    public function addActivity(Activite $activity): self
    {
        if (!$this->activity->contains($activity)) {
            $this->activity[] = $activity;
        }

        return $this;
    }

    public function removeActivity(Activite $activity): self
    {
        $this->activity->removeElement($activity);

        return $this;
    }

    /**
     * @return Collection|Saison[]
     */
    public function getSaison(): Collection
    {
        return $this->saison;
    }

    public function addSaison(Saison $saison): self
    {
        if (!$this->saison->contains($saison)) {
            $this->saison[] = $saison;
        }

        return $this;
    }

    public function removeSaison(Saison $saison): self
    {
        $this->saison->removeElement($saison);

        return $this;
    }

    /**
     * @return Collection|Tarif[]
     */
    public function getTarif(): Collection
    {
        return $this->tarif;
    }

    public function addTarif(Tarif $tarif): self
    {
        if (!$this->tarif->contains($tarif)) {
            $this->tarif[] = $tarif;
            $tarif->setVoyage($this);
        }

        return $this;
    }

    public function removeTarif(Tarif $tarif): self
    {
        if ($this->tarif->removeElement($tarif)) {
            // set the owning side to null (unless already changed)
            if ($tarif->getVoyage() === $this) {
                $tarif->setVoyage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Programme[]
     */
    public function getProgramme(): Collection
    {
        return $this->programme;
    }

    public function addProgramme(Programme $programme): self
    {
        if (!$this->programme->contains($programme)) {
            $this->programme[] = $programme;
            $programme->setVoyage($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): self
    {
        if ($this->programme->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getVoyage() === $this) {
                $programme->setVoyage(null);
            }
        }

        return $this;
    }

    public function getInfoPratique(): ?InfoPratique
    {
        return $this->infoPratique;
    }

    public function setInfoPratique(?InfoPratique $infoPratique): self
    {
        $this->infoPratique = $infoPratique;

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
            $favorie->setVoyage($this);
        }

        return $this;
    }

    public function removeFavorie(Favorie $favorie): self
    {
        if ($this->favorie->removeElement($favorie)) {
            // set the owning side to null (unless already changed)
            if ($favorie->getVoyage() === $this) {
                $favorie->setVoyage(null);
            }
        }

        return $this;
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

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }


    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * @return Collection|Panier[]
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): self
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers[] = $panier;
            $panier->setVoyage($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getVoyage() === $this) {
                $panier->setVoyage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsersParticipat(): Collection
    {
        return $this->usersParticipat;
    }

    public function addUsersParticipat(User $usersParticipat): self
    {
        if (!$this->usersParticipat->contains($usersParticipat)) {
            $this->usersParticipat[] = $usersParticipat;
            $usersParticipat->addParticipat($this);
        }

        return $this;
    }

    public function removeUsersParticipat(User $usersParticipat): self
    {
        if ($this->usersParticipat->removeElement($usersParticipat)) {
            $usersParticipat->removeParticipat($this);
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setVoyage($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getVoyage() === $this) {
                $order->setVoyage(null);
            }
        }

        return $this;
    }

   
 


}
