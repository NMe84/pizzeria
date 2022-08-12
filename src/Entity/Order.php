<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\OrderStatus;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Column(type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected ?int $id = null;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank]
    protected string $firstName = '';

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank]
    protected string $lastName = '';

    #[ORM\Column(type: 'string', nullable: true)]
    #[Assert\Email]
    protected ?string $email = null;

    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $phone = null;

    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $address = null;

    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $postalCode = null;

    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $city = null;

    #[ORM\Column(type: 'boolean', nullable: false)]
    protected bool $delivery = false;

    #[ORM\ManyToOne(targetEntity: Pizzeria::class)]
    #[Assert\NotNull]
    protected Pizzeria $pizzeria;

    /** @var Collection<Pizza> */
    #[ORM\OneToMany(mappedBy: 'order', targetEntity: Pizza::class, cascade: ['all'])]
    protected Collection $pizzas;

    #[ORM\Column(type: 'string', nullable: false)]
    protected string $status = OrderStatus::NEW;

    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $sendStatusUpdatesTo = null;

    #[ORM\Column(type: 'datetime', nullable: false)]
    protected \DateTimeInterface $createdAt;

    public function __construct(Pizzeria $pizzeria, Pizza $pizza)
    {
        $this->pizzeria = $pizzeria;
        $pizza->setOrder($this);
        $this->pizzas = new ArrayCollection([$pizza]);
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getSendStatusUpdatesTo(): ?string
    {
        return $this->sendStatusUpdatesTo;
    }

    public function setSendStatusUpdatesTo(?string $sendStatusUpdatesTo): self
    {
        $this->sendStatusUpdatesTo = $sendStatusUpdatesTo;
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

    public function getPizzeria(): Pizzeria
    {
        return $this->pizzeria;
    }

    public function setPizzeria(Pizzeria $pizzeria): self
    {
        $this->pizzeria = $pizzeria;
        return $this;
    }

    /** @return Collection<Pizza> */
    public function getPizzas(): Collection
    {
        return $this->pizzas;
    }

    /** @param Collection<Pizza> $pizzas */
    public function setPizzas(Collection $pizzas): self
    {
        $this->pizzas = $pizzas;
        return $this;
    }

    public function addPizza(Pizza $pizza): self
    {
        $this->pizzas->add($pizza);
        return $this;
    }

    public function removePizza(Pizza $pizza): self
    {
        $this->pizzas->removeElement($pizza);
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function __toString(): string
    {
        return $this->id ? 'Bestelling #' . str_pad((string) $this->id, 8, '0', STR_PAD_LEFT) : 'Nieuwe bestelling';
    }
}