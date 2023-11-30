<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomReg = null;

    #[ORM\ManyToOne(inversedBy: 'regions')]
    private ?Pays $pays = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdReg(): ?int
    {
        return $this->idReg;
    }

    public function setIdReg(int $idReg): static
    {
        $this->idReg = $idReg;

        return $this;
    }

    public function getNomReg(): ?string
    {
        return $this->nomReg;
    }

    public function setNomReg(string $nomReg): static
    {
        $this->nomReg = $nomReg;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): static
    {
        $this->pays = $pays;

        return $this;
    }
}
