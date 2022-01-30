<?php

namespace Pidia\Apps\Demo\Entity;

use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Pidia\Apps\Demo\Entity\Traits\EntityTrait;
use Pidia\Apps\Demo\Repository\TecnicoEncargadoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TecnicoEncargadoRepository::class)]
#[HasLifecycleCallbacks]
class TecnicoEncargado
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $nombreTecnico;

    #[ORM\Column(type: 'string', length: 50)]
    private $apellidoTecnico;

    #[ORM\Column(type: 'string', length: 8)]
    private $dni;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $direccion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreTecnico(): ?string
    {
        return $this->nombreTecnico;
    }

    public function setNombreTecnico(string $nombreTecnico): self
    {
        $this->nombreTecnico = $nombreTecnico;

        return $this;
    }

    public function getApellidoTecnico(): ?string
    {
        return $this->apellidoTecnico;
    }

    public function setApellidoTecnico(string $apellidoTecnico): self
    {
        $this->apellidoTecnico = $apellidoTecnico;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }
}
