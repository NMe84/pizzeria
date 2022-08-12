<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Pizza
{
    #[ORM\Column(type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected ?int $id = null;

    #[ORM\ManyToOne(targetEntity: PizzaBottom::class)]
    #[Assert\NotNull]
    protected ?PizzaBottom $bottom = null;

    #[ORM\ManyToOne(targetEntity: PizzaTopping::class)]
    #[Assert\NotNull]
    protected ?PizzaTopping $topping = null;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'pizzas')]
    #[Assert\NotNull]
    protected ?Order $order = null;

    public function __construct(PizzaBottom $bottom, PizzaTopping $topping)
    {
        $this->bottom = $bottom;
        $this->topping = $topping;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBottom(): ?PizzaBottom
    {
        return $this->bottom;
    }

    public function setBottom(PizzaBottom $bottom): self
    {
        $this->bottom = $bottom;
        return $this;
    }

    public function getTopping(): ?PizzaTopping
    {
        return $this->topping;
    }

    public function setTopping(PizzaTopping $topping): self
    {
        $this->topping = $topping;
        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function __toString(): string
    {
        if ($this->bottom || $this->topping) {
            return trim(implode(' ', [$this->topping, $this->bottom]));
        }
        return 'Nieuwe pizza';
    }
}