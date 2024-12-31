<?php

namespace App\Entity;

use App\Repository\EinkaufRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EinkaufRepository::class)]
class Einkauf
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'einkauf')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sorte $sorte = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $mengekg = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datum = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSorte(): ?Sorte
    {
        return $this->sorte;
    }

    public function setSorte(?Sorte $sorte): static
    {
        $this->sorte = $sorte;

        return $this;
    }

    public function getMengeKg(): ?float
    {
        return $this->mengekg;
    }

    public function setMengeKg(float $mengekg): static
    {
        $this->mengekg = $mengekg;

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
}
