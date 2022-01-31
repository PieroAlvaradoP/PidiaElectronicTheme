<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
use Pidia\Apps\Demo\Repository\EquipoRepository;

#[ORM\Entity(repositoryClass: EquipoRepository::class)]
#[HasLifecycleCallbacks]
class Equipo
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $modelo;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $numeroSerie;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $nombreEquipo;

    #[ORM\ManyToOne(targetEntity: EquipoMarca::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $marca;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): self
    {
        $this->modelo = $modelo;

        return $this;
    }

    public function getNumeroSerie(): ?string
    {
        return $this->numeroSerie;
    }

    public function setNumeroSerie(?string $numeroSerie): self
    {
        $this->numeroSerie = $numeroSerie;

        return $this;
    }

    public function getNombreEquipo(): ?string
    {
        return $this->nombreEquipo;
    }

    public function setNombreEquipo(?string $nombreEquipo): self
    {
        $this->nombreEquipo = $nombreEquipo;

        return $this;
    }

    public function getMarca(): ?EquipoMarca
    {
        return $this->marca;
    }

    public function setMarca(?EquipoMarca $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getModelo();
    }
}
