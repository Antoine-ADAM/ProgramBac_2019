<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiapoRepository")
 */
class Diapo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Page", mappedBy="diapo", orphanRemoval=true)
     */
    private $Page;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Identity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $identity;

    public function __construct()
    {
        $this->Page = new ArrayCollection();
        $this->code="";
    }
    public function updateModif(ObjectManager $om): void
    {
        $this->getIdentity()->setModifAt(new \DateTime());
        $this->code="AxesNAff
EffDess\n";
        foreach($this->getPage() as $page){
            $ofset=-12;
            foreach(str_split($page->getText(),33) as $line){
                $ofset+=12;
                $line=rtrim($line);
                if(strlen($line)==0)continue;
                $this->code.="Texte({$ofset},0,\"{$line}\")\n";
            }
            $this->code.="Pause 
EffDess\n";
        }
        $this->code.="AxesAff ";
        $om->persist($this);
        $om->flush();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }
    /**
     * @return Collection|Page[]
     */
    public function getPage(): Collection
    {
        return $this->Page;
    }

    public function addPage(Page $page): self
    {
        if (!$this->Page->contains($page)) {
            $this->Page[] = $page;
            $page->setDiapo($this);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->Page->contains($page)) {
            $this->Page->removeElement($page);
            // set the owning side to null (unless already changed)
            if ($page->getDiapo() === $this) {
                $page->setDiapo(null);
            }
        }

        return $this;
    }

    public function getIdentity(): ?Identity
    {
        return $this->identity;
    }

    public function setIdentity(Identity $identity): self
    {
        $this->identity = $identity;

        return $this;
    }
}
