<?php

namespace App\Entity;

use App\Repository\CaMemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaMemberRepository::class)]
class CaMember
{
    #[ORM\Id]
    #[ORM\OneToOne(inversedBy: 'caMember', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $position = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): static
    {
        $this->position = $position;

        return $this;
    }
}
