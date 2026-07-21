<?php

namespace App\Entity;

use App\Repository\CaMemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaMemberRepository::class)]
class CaMember
{
    #[ORM\Id]
    #[ORM\OneToOne(inversedBy: 'caMember', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user')]
    private ?user $user = null;

    #[ORM\Column(length: 50)]
    private ?string $position = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

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

    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }
}
