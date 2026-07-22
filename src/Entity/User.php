<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Entity\CustomerOrder;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_user')]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $firstname = null;

    /**
     * Gestion du site : 'admin' ou 'user'. Ne pas confondre avec le statut
     * (member / coach / ca_member), géré via les entités liées (Member, Coach, CaMember).
     */
    #[ORM\Column(length: 20)]
    private ?string $role = 'user';

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Member::class, cascade: ['persist', 'remove'])]
    private ?Member $member = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Coach::class, cascade: ['persist', 'remove'])]
    private ?Coach $coach = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: CaMember::class, cascade: ['persist', 'remove'])]
    private ?CaMember $caMember = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Actuality::class)]
    private Collection $actualities;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Event::class)]
    private Collection $events;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Cart::class)]
    private ?Cart $cart = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CustomerOrder::class)]
    private Collection $orders;

    public function __construct()
    {
        $this->actualities = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActualities(): Collection
    {
        return $this->actualities;
    }

    public function addActuality(Actuality $actuality): static
    {
        if (!$this->actualities->contains($actuality)) {
            $this->actualities->add($actuality);
            $actuality->setUser($this);
        }

        return $this;
    }

    public function removeActuality(Actuality $actuality): static
    {
        if ($this->actualities->removeElement($actuality)) {
            // set the owning side to null (unless already changed)
            if ($actuality->getUser() === $this) {
                $actuality->setUser(null);
            }
        }

        return $this;
    }

    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setUser($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            if ($event->getUser() === $this) {
                $event->setUser(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): static
    {
        // Met à jour le propiétaire de la relation si nécessaire
        if ($member !== null && $member->getUser() !== $this) {
            $member->setUser($this);
        }

        $this->member = $member;

        return $this;
    }

    public function isMember(): bool
    {
        return $this->member !== null;
    }

    public function getCaMember(): ?CaMember
    {
        return $this->caMember;
    }

    public function setCaMember(?CaMember $caMember): static
    {
        // Met à jour le propiétaire de la relation si nécessaire
        if ($caMember !== null && $caMember->getUser() !== $this) {
            $caMember->setUser($this);
        }

        $this->caMember = $caMember;

        return $this;
    }

    public function isCaMember(): bool
    {
        return $this->caMember !== null;
    }

    public function getCoach(): ?Coach
    {
        return $this->coach;
    }

    public function setCoach(?Coach $coach): static
    {
        // Met à jour le propiétaire de la relation si nécessaire
        if ($coach !== null && $coach->getUser() !== $this) {
            $coach->setUser($this);
        }

        $this->coach = $coach;

        return $this;
    }

    public function isCoach(): bool
    {
        return $this->coach !== null;
    }

    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(CustomerOrder $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(CustomerOrder $order): static
    {
        if ($this->orders->removeElement($order)) {
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     * 
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = ['ROLE_USER'];

        if ($this->role === 'admin') {
            $roles[] = 'ROLE_ADMIN';
        }

        return array_unique($roles);
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0" . self::class . "\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }
}
