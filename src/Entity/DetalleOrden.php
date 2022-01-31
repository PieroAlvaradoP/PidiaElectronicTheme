<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
use Pidia\Apps\Demo\Repository\DetalleOrdenRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetalleOrdenRepository::class)]
#[HasLifecycleCallbacks]
class DetalleOrden
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: TipoServicio::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $tipoServicioDetalleOrden;

    #[ORM\ManyToOne(targetEntity: OrdenServicio::class, inversedBy: 'detalleOrdens')]
    #[ORM\JoinColumn(nullable: false)]
    private $ordenServicio;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $observacion;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $precio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoServicioDetalleOrden(): ?TipoServicio
    {
        return $this->tipoServicioDetalleOrden;
    }

    public function setTipoServicioDetalleOrden(?TipoServicio $tipoServicioDetalleOrden): self
    {
        $this->tipoServicioDetalleOrden = $tipoServicioDetalleOrden;

        return $this;
    }

    public function getOrdenServicio(): ?OrdenServicio
    {
        return $this->ordenServicio;
    }

    public function setOrdenServicio(?OrdenServicio $ordenServicio): self
    {
        $this->ordenServicio = $ordenServicio;

        return $this;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(?string $observacion): self
    {
        $this->observacion = $observacion;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(?string $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getOrdenServicio();
    }

}
