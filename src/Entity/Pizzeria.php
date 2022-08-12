<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Pizzeria
{
    #[ORM\Column(type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected ?int $id = null;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    #[Assert\NotBlank]
    protected string $name = '';

    #[ORM\Column(type: 'boolean', nullable: false)]
    protected bool $delivery = true;

    #[ORM\Column(type: 'boolean', nullable: false)]
    protected bool $pickup = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function isDelivery(): bool
    {
        return $this->delivery;
    }

    public function setDelivery(bool $delivery): self
    {
        $this->delivery = $delivery;
        return $this;
    }

    public function isPickup(): bool
    {
        return $this->pickup;
    }

    public function setPickup(bool $pickup): self
    {
        $this->pickup = $pickup;
        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?: 'Nieuwe pizzeria';
    }
}