<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=429)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Diapo", inversedBy="Page")
     * @ORM\JoinColumn(nullable=false)
     */
    private $diapo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getDiapo(): ?Diapo
    {
        return $this->diapo;
    }

    public function setDiapo(?Diapo $diapo): self
    {
        $this->diapo = $diapo;

        return $this;
    }
}
