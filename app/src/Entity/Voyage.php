<?php

namespace App\Entity;

use App\Repository\VoyageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoyageRepository::class)
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
     * @ORM\OneToMany(targetEntity=Tarif::class, mappedBy="voyage")
     */
    private $tarif;

    /**
     * @ORM\OneToMany(targetEntity=Programme::class, mappedBy="voyage")
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


}
