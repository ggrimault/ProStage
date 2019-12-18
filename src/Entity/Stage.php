<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 */
class Stage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $descMission;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mail;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entreprise", inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $monEntreprise;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Formation", inversedBy="stages")
     */
    private $mesFormations;

    public function __construct()
    {
        $this->mesFormations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescMission(): ?string
    {
        return $this->descMission;
    }

    public function setDescMission(string $descMission): self
    {
        $this->descMission = $descMission;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMonEntreprise(): ?Entreprise
    {
        return $this->monEntreprise;
    }

    public function setMonEntreprise(?Entreprise $monEntreprise): self
    {
        $this->monEntreprise = $monEntreprise;

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getMesFormations(): Collection
    {
        return $this->mesFormations;
    }

    public function addMesFormation(Formation $mesFormation): self
    {
        if (!$this->mesFormations->contains($mesFormation)) {
            $this->mesFormations[] = $mesFormation;
        }

        return $this;
    }

    public function removeMesFormation(Formation $mesFormation): self
    {
        if ($this->mesFormations->contains($mesFormation)) {
            $this->mesFormations->removeElement($mesFormation);
        }

        return $this;
    }
}
