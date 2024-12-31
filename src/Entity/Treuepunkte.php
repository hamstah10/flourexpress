<?php

namespace App\Entity;

use App\Repository\TreuepunkteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TreuepunkteRepository::class)]
class Treuepunkte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datum = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Sorte $sorte = null;

    #[ORM\Column(length: 255)]
    private ?string $menge = null;

    #[ORM\Column(nullable: true)]
    private ?bool $erledigt = null;

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

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(\DateTimeInterface $datum): static
    {
        $this->datum = $datum;

        return $this;
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

    public function getMenge(): ?string
    {
        return $this->menge;
    }

    public function setMenge(string $menge): static
    {
        $this->menge = $menge;

        return $this;
    }

    public function isErledigt(): ?bool
    {
        return $this->erledigt;
    }

    public function setErledigt(?bool $erledigt): static
    {
        $this->erledigt = $erledigt;

        return $this;
    }
}
