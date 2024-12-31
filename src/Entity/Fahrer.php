<?php

namespace App\Entity;

use App\Repository\FahrerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FahrerRepository::class)]
class Fahrer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $verguetung1g = null; // Hier wurde der Typ auf float geändert

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $verguetung05g = null; // Hier wurde der Typ auf float geändert

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

    public function getVerguetung1g(): ?float
    {
        return $this->verguetung1g;
    }

    public function setVerguetung1g(float $verguetung1g): static
    {
        $this->verguetung1g = $verguetung1g;
        return $this;
    }

    public function getVerguetung05g(): ?float
    {
        return $this->verguetung05g;
    }

    public function setVerguetung05g(float $verguetung05g): static
    {
        $this->verguetung05g = $verguetung05g;
        return $this;
    }
}
