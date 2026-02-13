<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\InvitationStatus;
use App\Repository\HouseHoldInvitationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HouseHoldInvitationRepository::class)]
#[ApiResource]
class HouseHoldInvitation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 64, unique: true)]
    private ?string $token;

    #[ORM\Column(type: 'string', enumType: InvitationStatus::class)]
    private InvitationStatus $status = InvitationStatus::PENDING;

    #[ORM\Column]
    private ?\DateTime $expiresAt = null;

    #[ORM\ManyToOne(inversedBy: 'invitations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?HouseHold $houseHold = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getStatus(): ?InvitationStatus
    {
        return $this->status;
    }

    public function setStatus(InvitationStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getExpiresAt(): ?\DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTime $expiresAt): static
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getHouseHold(): ?HouseHold
    {
        return $this->houseHold;
    }

    public function setHouseHold(?HouseHold $houseHold): static
    {
        $this->houseHold = $houseHold;

        return $this;
    }
}
