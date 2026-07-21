<?php

namespace App\Entity;

use App\Repository\ActualityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActualityRepository::class)]
class Actuality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_actuality')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'text')]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $datePublication = null;

    #[ORM\ManyToOne(inversedBy: 'actualities', targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getDatePublication(): ?\DateTime
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTime $datePublication): static
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
 
    public function setUser(?User $user): static
    {
        $this->user = $user;
 
        return $this;
    }
}
