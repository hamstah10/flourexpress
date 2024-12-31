<?php

namespace App\Entity;

use App\Repository\SorteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SorteRepository::class)]
class Sorte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2)]
    private ?float $einkaufspreis_pro_kg = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2)]
    private ?float $verkaufspreis1g = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2)]
    private ?float $verkaufspreis05g = null;

    /**
     * @var Collection<int, Einkauf>
     */
    #[ORM\OneToMany(targetEntity: Einkauf::class, mappedBy: 'sorte')]
    private Collection $einkauf;

    /**
     * @var Collection<int, Verkauf>
     */
    #[ORM\OneToMany(targetEntity: Verkauf::class, mappedBy: 'sorte')]
    private Collection $sorte;

 

    public function __construct()
    {
        $this->einkauf = new ArrayCollection();
        $this->sorte = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEinkaufspreisProKg(): ?float
    {
        return $this->einkaufspreis_pro_kg;
    }

    public function setEinkaufspreisProKg(float $einkaufspreis_pro_kg): static
    {
        $this->einkaufspreis_pro_kg = $einkaufspreis_pro_kg;

        return $this;
    }

    public function getVerkaufspreis1g(): ?float
    {
        return $this->verkaufspreis1g;
    }

    public function setVerkaufspreis1g(float $verkaufspreis1g): static
    {
        $this->verkaufspreis1g = $verkaufspreis1g;

        return $this;
    }

    public function getVerkaufspreis05g(): ?float
    {
        return $this->verkaufspreis05g;
    }

    public function setVerkaufspreis05g(float $verkaufspreis05g): static
    {
        $this->verkaufspreis05g = $verkaufspreis05g;

        return $this;
    }

    /**
     * @return Collection<int, Einkauf>
     */
    public function getEinkauf(): Collection
    {
        return $this->einkauf;
    }

    public function addEinkauf(Einkauf $einkauf): static
    {
        if (!$this->einkauf->contains($einkauf)) {
            $this->einkauf->add($einkauf);
            $einkauf->setSorte($this);
        }

        return $this;
    }

    public function removeEinkauf(Einkauf $einkauf): static
    {
        if ($this->einkauf->removeElement($einkauf)) {
            // set the owning side to null (unless already changed)
            if ($einkauf->getSorte() === $this) {
                $einkauf->setSorte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Verkauf>
     */
    public function getSorte(): Collection
    {
        return $this->sorte;
    }

    public function addSorte(Verkauf $sorte): static
    {
        if (!$this->sorte->contains($sorte)) {
            $this->sorte->add($sorte);
            $sorte->setSorte($this);
        }

        return $this;
    }

    public function removeSorte(Verkauf $sorte): static
    {
        if ($this->sorte->removeElement($sorte)) {
            // set the owning side to null (unless already changed)
            if ($sorte->getSorte() === $this) {
                $sorte->setSorte(null);
            }
        }

        return $this;
    }

   
}
