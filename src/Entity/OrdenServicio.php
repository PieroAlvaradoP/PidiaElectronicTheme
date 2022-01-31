<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
use Pidia\Apps\Demo\Repository\OrdenServicioRepository;

#[ORM\Entity(repositoryClass: OrdenServicioRepository::class)]
#[HasLifecycleCallbacks]
class OrdenServicio
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 6)]
    private $numeroOrden;

    #[ORM\ManyToOne(targetEntity: Cliente::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $clienteOrden;

    #[ORM\ManyToOne(targetEntity: TecnicoEncargado::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $tecnicoOrden;

    #[ORM\Column(type: 'datetime')]
    private $fechaIngreso;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $fechaSalida;

    #[ORM\ManyToOne(targetEntity: Equipo::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $equipo;

    #[ORM\ManyToMany(targetEntity: Estado::class)]
    private $estadoOrden;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $precio;

    #[ORM\OneToMany(mappedBy: 'ordenServicio', targetEntity: DetalleOrden::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private $detalleOrdens;

    public function __construct()
    {
        $this->estadoOrden = new ArrayCollection();
        $this->detalleOrdens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroOrden(): ?string
    {
        return $this->numeroOrden;
    }

    public function setNumeroOrden(string $numeroOrden): self
    {
        $this->numeroOrden = $numeroOrden;

        return $this;
    }

    public function getClienteOrden(): ?Cliente
    {
        return $this->clienteOrden;
    }

    public function setClienteOrden(?Cliente $clienteOrden): self
    {
        $this->clienteOrden = $clienteOrden;

        return $this;
    }

    public function getTecnicoOrden(): ?TecnicoEncargado
    {
        return $this->tecnicoOrden;
    }

    public function setTecnicoOrden(?TecnicoEncargado $tecnicoOrden): self
    {
        $this->tecnicoOrden = $tecnicoOrden;

        return $this;
    }

    public function getFechaIngreso(): ?\DateTimeInterface
    {
        return $this->fechaIngreso;
    }

    public function setFechaIngreso(\DateTimeInterface $fechaIngreso): self
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    public function getFechaSalida(): ?\DateTimeInterface
    {
        return $this->fechaSalida;
    }

    public function setFechaSalida(?\DateTimeInterface $fechaSalida): self
    {
        $this->fechaSalida = $fechaSalida;

        return $this;
    }

    public function getEquipo(): ?Equipo
    {
        return $this->equipo;
    }

    public function setEquipo(?Equipo $equipo): self
    {
        $this->equipo = $equipo;

        return $this;
    }

    /**
     * @return Collection|Estado[]
     */
    public function getEstadoOrden(): Collection
    {
        return $this->estadoOrden;
    }

    public function addEstadoOrden(Estado $estadoOrden): self
    {
        if (!$this->estadoOrden->contains($estadoOrden)) {
            $this->estadoOrden[] = $estadoOrden;
        }

        return $this;
    }

    public function removeEstadoOrden(Estado $estadoOrden): self
    {
        $this->estadoOrden->removeElement($estadoOrden);

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

    /**
     * @return Collection|DetalleOrden[]
     */
    public function getDetalleOrdens(): Collection
    {
        return $this->detalleOrdens;
    }

    public function addDetalleOrden(DetalleOrden $detalleOrden): self
    {
        if (!$this->detalleOrdens->contains($detalleOrden)) {
            $this->detalleOrdens[] = $detalleOrden;
            $detalleOrden->setOrdenServicio($this);
        }

        return $this;
    }

    public function removeDetalleOrden(DetalleOrden $detalleOrden): self
    {
        if ($this->detalleOrdens->removeElement($detalleOrden)) {
            // set the owning side to null (unless already changed)
            if ($detalleOrden->getOrdenServicio() === $this) {
                $detalleOrden->setOrdenServicio(null);
            }
        }

        return $this;
    }
}
