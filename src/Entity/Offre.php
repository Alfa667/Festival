<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    private ?Etablissement $etablissement = null;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    private ?TypeChambre $typeChambre = null;

    #[ORM\Column]
    private ?int $nombreChambres = null;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtablissement(): ?Etablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(?Etablissement $etablissement): self
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    public function getTypeChambre(): ?TypeChambre
    {
        return $this->typeChambre;
    }

    public function setTypeChambre(?TypeChambre $typeChambre): self
    {
        $this->typeChambre = $typeChambre;

        return $this;
    }

    public function getNombreChambres(): ?int
    {
        return $this->nombreChambres;
    }

    public function setNombreChambres(int $nombreChambres): self
    {
        $this->nombreChambres = $nombreChambres;

        return $this;
    }

    public function __toString()
    {
        return $this->etablissement->getNom();
    }

   
}
