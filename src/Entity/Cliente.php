<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
use Pidia\Apps\Demo\Repository\ClienteRepository;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
#[HasLifecycleCallbacks]
class Cliente
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $nombreCliente;

    #[ORM\Column(type: 'string', length: 50)]
    private $apellidosCliente;

    #[ORM\Column(type: 'string', length: 11, nullable: true)]
    private $ruc;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $direccionCliente;

    #[ORM\Column(type: 'string', length: 9, nullable: true)]
    private $telefono;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreCliente(): ?string
    {
        return $this->nombreCliente;
    }

    public function setNombreCliente(string $nombreCliente): self
    {
        $this->nombreCliente = $nombreCliente;

        return $this;
    }

    public function getApellidosCliente(): ?string
    {
        return $this->apellidosCliente;
    }

    public function setApellidosCliente(string $apellidosCliente): self
    {
        $this->apellidosCliente = $apellidosCliente;

        return $this;
    }

    public function getRuc(): ?string
    {
        return $this->ruc;
    }

    public function setRuc(?string $ruc): self
    {
        $this->ruc = $ruc;

        return $this;
    }

    public function getDireccionCliente(): ?string
    {
        return $this->direccionCliente;
    }

    public function setDireccionCliente(?string $direccionCliente): self
    {
        $this->direccionCliente = $direccionCliente;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNombreCliente().' '.$this->getApellidosCliente();
    }
}
