<?php

namespace App\Entity;

use App\Enum\BowType;
use App\Repository\MemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\OneToOne(inversedBy: 'member', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\Column(length: 50)]
    private ?string $licenceNumber = null;

    #[ORM\Column(length: 20, nullable: true, enumType: BowType::class)]
    private ?BowType  $bowType = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getLicenceNumber(): ?string
    {
        return $this->licenceNumber;
    }

    public function setLicenceNumber(string $licenceNumber): static
    {
        $this->licenceNumber = $licenceNumber;

        return $this;
    }

    public function getBowType(): ?BowType
    {
        return $this->bowType;
    }

    public function setBowType(?BowType $bowType): static
    {
        $this->bowType = $bowType;

        return $this;
    }
}
