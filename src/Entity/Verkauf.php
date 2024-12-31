<?php

namespace App\Entity;

use App\Repository\VerkaufRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VerkaufRepository::class)]
class Verkauf
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sorte')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sorte $sorte = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $menge1g = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $menge05g = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datum = null;

    #[ORM\ManyToOne(targetEntity: Fahrer::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fahrer $fahrer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSorte(): ?sorte
    {
        return $this->sorte;
    }

    public function setSorte(?sorte $sorte): static
    {
        $this->sorte = $sorte;

        return $this;
    }

    public function getMenge1g(): ?float
    {
        return $this->menge1g;
    }

    public function setMenge1g(float $menge1g): static
    {
        $this->menge1g = $menge1g;

        return $this;
    }

    public function getMenge05g(): ?float
    {
        return $this->menge05g;
    }

    public function setMenge05g(float $menge05g): static
    {
        $this->menge05g = $menge05g;

        return $this;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(\DateTimeInterface $datum): static
    {
        $this->datum = $datum;

        return $this;
    }

    public function getFahrer(): ?Fahrer
    {
        return $this->fahrer;
    }

    public function setFahrer(?Fahrer $fahrer): self
    {
        $this->fahrer = $fahrer;
        return $this;
    }
}
