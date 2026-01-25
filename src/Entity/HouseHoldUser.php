<?php

namespace App\Entity;

use App\Repository\HouseHoldUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HouseHoldUserRepository::class)]
class HouseHoldUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'houseHoldUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?HouseHold $houseHold = null;

    #[ORM\ManyToOne(inversedBy: 'houseHoldUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 30)]
    private ?string $role = null;

    #[ORM\Column(nullable: true)]
    private ?float $shareRatio = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?HouseHold
    {
        return $this->houseHold;
    }

    public function sethouseHold(?HouseHold $houseHold): static
    {
        $this->houseHold = $houseHold;

        return $this;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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

    public function getShareRatio(): ?float
    {
        return $this->shareRatio;
    }

    public function setShareRatio(?float $shareRatio): static
    {
        $this->shareRatio = $shareRatio;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
