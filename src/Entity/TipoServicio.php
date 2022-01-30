<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
use Pidia\Apps\Demo\Repository\TipoServicioRepository;

#[ORM\Entity(repositoryClass: TipoServicioRepository::class)]
#[HasLifecycleCallbacks]
class TipoServicio
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $nombreServicio;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $detalleServicio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreServicio(): ?string
    {
        return $this->nombreServicio;
    }

    public function setNombreServicio(string $nombreServicio): self
    {
        $this->nombreServicio = $nombreServicio;

        return $this;
    }

    public function getDetalleServicio(): ?string
    {
        return $this->detalleServicio;
    }

    public function setDetalleServicio(?string $detalleServicio): self
    {
        $this->detalleServicio = $detalleServicio;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNombreServicio();
    }
}
