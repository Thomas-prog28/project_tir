<?php

namespace App\Entity;

use App\Repository\CoachRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoachRepository::class)]
class Coach
{
    #[ORM\Id]
    #[ORM\OneToOne(inversedBy: 'coach', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $diplomaNumber = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $speciality = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDiplomaNumber(): ?string
    {
        return $this->diplomaNumber;
    }

    public function setDiplomaNumber(?string $diplomaNumber): static
    {
        $this->diplomaNumber = $diplomaNumber;

        return $this;
    }

    public function getSpeciality(): ?string
    {
        return $this->speciality;
    }

    public function setSpeciality(?string $speciality): static
    {
        $this->speciality = $speciality;

        return $this;
    }
}
