<?php

namespace App\Entity;

use App\Repository\CoachRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoachRepository::class)]
class Coach
{
    #[ORM\Id]
    #[ORM\OneToOne(inversedBy: 'coach', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user')]
    private ?user $user = null;

    #[ORM\Column(length: 50)]
    private ?string $diplomaNumber = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $speciality = null;

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

    public function getDiplomaNumber(): ?string
    {
        return $this->diplomaNumber;
    }

    public function setDiplomaNumber(string $diplomaNumber): static
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
