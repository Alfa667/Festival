<?php

namespace App\Entity;

use App\Repository\AttributionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttributionRepository::class)]
class Attribution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    
  
    

    #[ORM\ManyToOne(inversedBy: 'attributions')]
    private ?Groupe $groupe = null;

    #[ORM\Column]
    private ?int $nombreChambres = null;

    #[ORM\ManyToOne]
    private ?Offre $offre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    
  

   
  
    

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

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

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): self
    {
        $this->offre = $offre;

        return $this;
    }
}