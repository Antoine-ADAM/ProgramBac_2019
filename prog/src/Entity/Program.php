<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramRepository")
 */
class Program
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Identity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $identity;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\LiaisonProgram", mappedBy="programs")
     */
    private $liaisonProgramsUp;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LiaisonProgram", mappedBy="parent", orphanRemoval=true)
     */
    private $liaisonProgramDown;

    public function __construct()
    {
        $this->diapos = new ArrayCollection();
        $this->programs = new ArrayCollection();
        $this->liaisonProgramsUp = new ArrayCollection();
        $this->liaisonProgramDown = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|diapo[]
     */
    public function getDiapos(): Collection
    {
        return $this->diapos;
    }

    public function addDiapo(diapo $diapo): self
    {
        if (!$this->diapos->contains($diapo)) {
            $this->diapos[] = $diapo;
        }

        return $this;
    }

    public function removeDiapo(diapo $diapo): self
    {
        if ($this->diapos->contains($diapo)) {
            $this->diapos->removeElement($diapo);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(self $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
        }

        return $this;
    }

    public function removeProgram(self $program): self
    {
        if ($this->programs->contains($program)) {
            $this->programs->removeElement($program);
        }

        return $this;
    }

    public function getIdentity(): ?Identity
    {
        return $this->identity;
    }

    public function setIdentity(?Identity $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * @return Collection|LiaisonProgram[]
     */
    public function getLiaisonProgramsUp(): Collection
    {
        return $this->liaisonProgramsUp;
    }

    public function addLiaisonProgramUp(LiaisonProgram $liaisonProgram): self
    {
        if (!$this->liaisonProgramsUp->contains($liaisonProgram)) {
            $this->liaisonProgramsUp[] = $liaisonProgram;
            $liaisonProgram->addProgram($this);
        }

        return $this;
    }

    public function removeLiaisonProgramUp(LiaisonProgram $liaisonProgram): self
    {
        if ($this->liaisonProgramsUp->contains($liaisonProgram)) {
            $this->liaisonProgramsUp->removeElement($liaisonProgram);
            $liaisonProgram->removeProgram($this);
        }

        return $this;
    }

    /**
     * @return Collection|LiaisonProgram[]
     */
    public function getLiaisonProgramDown(): Collection
    {
        return $this->liaisonProgramDown;
    }

    public function addLiaisonProgramDown(LiaisonProgram $liaisonProgramDown): self
    {
        if (!$this->liaisonProgramDown->contains($liaisonProgramDown)) {
            $this->liaisonProgramDown[] = $liaisonProgramDown;
            $liaisonProgramDown->setParent($this);
        }

        return $this;
    }

    public function removeLiaisonProgramDown(LiaisonProgram $liaisonProgramDown): self
    {
        if ($this->liaisonProgramDown->contains($liaisonProgramDown)) {
            $this->liaisonProgramDown->removeElement($liaisonProgramDown);
            // set the owning side to null (unless already changed)
            if ($liaisonProgramDown->getParent() === $this) {
                $liaisonProgramDown->setParent(null);
            }
        }

        return $this;
    }
}
