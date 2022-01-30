<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
use Pidia\Apps\Demo\Repository\EquipoMarcaRepository;

#[ORM\Entity(repositoryClass: EquipoMarcaRepository::class)]
#[HasLifecycleCallbacks]
class EquipoMarca
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $nombreMarca;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $detalleMarca;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreMarca(): ?string
    {
        return $this->nombreMarca;
    }

    public function setNombreMarca(string $nombreMarca): self
    {
        $this->nombreMarca = $nombreMarca;

        return $this;
    }

    public function getDetalleMarca(): ?string
    {
        return $this->detalleMarca;
    }

    public function setDetalleMarca(?string $detalleMarca): self
    {
        $this->detalleMarca = $detalleMarca;

        return $this;
    }

    public function getActivo(): ?string
    {
        return $this->activo;
    }

    public function changeActivo(): void
    {
        $this->activo = !$this->getActivo();
    }

    public function __toString(): string
    {
        return $this->getNombreMarca();
    }
}
