<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LiaisonProgramRepository")
 */
class LiaisonProgram
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
    private $name;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program")
     * @ORM\JoinColumn(nullable=false)
     */
    private $programPrincipal;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Diapo")
     */
    private $diapos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Program", inversedBy="liaisonPrograms")
     */
    private $programs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program", inversedBy="liaisonProgramDown")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parent;

    public function __construct()
    {
        $this->diapos = new ArrayCollection();
        $this->programs = new ArrayCollection();
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getProgramPrincipal(): ?Program
    {
        return $this->programPrincipal;
    }

    public function setProgramPrincipal(?Program $id_program): self
    {
        $this->programPrincipal = $id_program;

        return $this;
    }

    /**
     * @return Collection|Diapo[]
     */
    public function getDiapos(): Collection
    {
        return $this->diapos;
    }

    public function addDiapo(Diapo $diapo): self
    {
        if (!$this->diapos->contains($diapo)) {
            $this->diapos[] = $diapo;
        }

        return $this;
    }

    public function removeDiapo(Diapo $diapo): self
    {
        if ($this->diapos->contains($diapo)) {
            $this->diapos->removeElement($diapo);
        }

        return $this;
    }

    /**
     * @return Collection|Program[]
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        if ($this->programs->contains($program)) {
            $this->programs->removeElement($program);
        }

        return $this;
    }

    public function getParent(): ?Program
    {
        return $this->parent;
    }

    public function setParent(?Program $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
