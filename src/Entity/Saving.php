<?php

namespace App\Entity;

use App\Repository\SavingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SavingRepository::class)]
class Saving
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'savings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?HouseHold $houseHold = null;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $targetAmount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $currentAmount = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getTargetAmount(): ?string
    {
        return $this->targetAmount;
    }

    public function setTargetAmount(?string $targetAmount): static
    {
        $this->targetAmount = $targetAmount;

        return $this;
    }

    public function getCurrentAmount(): ?string
    {
        return $this->currentAmount;
    }

    public function setCurrentAmount(string $currentAmount): static
    {
        $this->currentAmount = $currentAmount;

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

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
