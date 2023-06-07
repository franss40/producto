<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?int $existencia = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fecha = null;

    #[ORM\Column]
    private ?bool $existe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getExistencia(): ?int
    {
        return $this->existencia;
    }

    public function setExistencia(int $existencia): self
    {
        $this->existencia = $existencia;

        return $this;
    }

    public function getFecha(): String
    {
        return $this->fecha->format('d-m-Y');
    }

    public function setFecha(\DateTime $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function isExiste(): ?bool
    {
        return $this->existe;
    }

    public function setExiste(bool $existe): self
    {
        $this->existe = $existe;

        return $this;
    }
}
