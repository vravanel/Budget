<?php

namespace App\Entity;

use App\Enum\SplitMode;
use App\Repository\HouseHoldRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HouseHoldRepository::class)]
#[ORM\HasLifecycleCallbacks]
class HouseHold
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private ?string $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'houseHold')]
    private Collection $members;

    #[ORM\Column(enumType: SplitMode::class, options: ['default' => 'FIFTY_FIFTY'])]
    private SplitMode $splitMode = SplitMode::FIFTY_FIFTY;

    /**
     * @var Collection<int, Income>
     */
    #[ORM\OneToMany(targetEntity: Income::class, mappedBy: 'houseHold')]
    private Collection $incomes;

    /**
     * @var Collection<int, Expense>
     */
    #[ORM\OneToMany(targetEntity: Expense::class, mappedBy: 'houseHold')]
    private Collection $expenses;

    /**
     * @var Collection<int, Saving>
     */
    #[ORM\OneToMany(targetEntity: Saving::class, mappedBy: 'houseHold')]
    private Collection $savings;

    /**
     * @var Collection<int, HouseHoldInvitation>
     */
    #[ORM\OneToMany(targetEntity: HouseHoldInvitation::class, mappedBy: 'houseHold')]
    private Collection $invitations;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->incomes = new ArrayCollection();
        $this->expenses = new ArrayCollection();
        $this->savings = new ArrayCollection();
        $this->invitations = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?string
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(User $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->setHouseHold($this);
        }

        return $this;
    }

    public function removeMember(User $member): static
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getHouseHold() === $this) {
                $member->setHouseHold(null);
            }
        }

        return $this;
    }

    public function getSplitMode(): SplitMode
    {
        return $this->splitMode;
    }

    public function setSplitMode(SplitMode $splitMode): static
    {
        $this->splitMode = $splitMode;

        return $this;
    }

    /**
     * @return Collection<int, Income>
     */
    public function getIncomes(): Collection
    {
        return $this->incomes;
    }

    public function addIncome(Income $income): static
    {
        if (!$this->incomes->contains($income)) {
            $this->incomes->add($income);
            $income->setHouseHold($this);
        }

        return $this;
    }

    public function removeIncome(Income $income): static
    {
        if ($this->incomes->removeElement($income)) {
            // set the owning side to null (unless already changed)
            if ($income->getHouseHold() === $this) {
                $income->setHouseHold(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Expense>
     */
    public function getExpenses(): Collection
    {
        return $this->expenses;
    }

    public function addExpense(Expense $expense): static
    {
        if (!$this->expenses->contains($expense)) {
            $this->expenses->add($expense);
            $expense->setHouseHold($this);
        }

        return $this;
    }

    public function removeExpense(Expense $expense): static
    {
        if ($this->expenses->removeElement($expense)) {
            // set the owning side to null (unless already changed)
            if ($expense->getHouseHold() === $this) {
                $expense->setHouseHold(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Saving>
     */
    public function getSavings(): Collection
    {
        return $this->savings;
    }

    public function addSaving(Saving $saving): static
    {
        if (!$this->savings->contains($saving)) {
            $this->savings->add($saving);
            $saving->setHouseHold($this);
        }

        return $this;
    }

    public function removeSaving(Saving $saving): static
    {
        if ($this->savings->removeElement($saving)) {
            // set the owning side to null (unless already changed)
            if ($saving->getHouseHold() === $this) {
                $saving->setHouseHold(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HouseHoldInvitation>
     */
    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function addInvitation(HouseHoldInvitation $invitation): static
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations->add($invitation);
            $invitation->setHouseHold($this);
        }

        return $this;
    }

    public function removeInvitation(HouseHoldInvitation $invitation): static
    {
        if ($this->invitations->removeElement($invitation)) {
            // set the owning side to null (unless already changed)
            if ($invitation->getHouseHold() === $this) {
                $invitation->setHouseHold(null);
            }
        }

        return $this;
    }
}
