<?php

namespace App\Entity;

use App\Repository\HouseholdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\BudgetRepartition;
use App\Enum\UserSituation;

#[ORM\Entity(repositoryClass: HouseholdRepository::class)]
class Household
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(enumType: UserSituation::class)]
    private ?UserSituation $type = null;

    #[ORM\Column(enumType: BudgetRepartition::class)]
    private ?BudgetRepartition $distributionType = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    /**
     * @var Collection<int, HouseHoldUser>
     */
    #[ORM\OneToMany(targetEntity: HouseHoldUser::class, mappedBy: 'user')]
    private Collection $houseHoldUsers;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'houseHold')]
    private Collection $categories;

    /**
     * @var Collection<int, Expense>
     */
    #[ORM\OneToMany(targetEntity: Expense::class, mappedBy: 'houseHold')]
    private Collection $expenses;

    /**
     * @var Collection<int, Income>
     */
    #[ORM\OneToMany(targetEntity: Income::class, mappedBy: 'houseHold')]
    private Collection $incomes;

    /**
     * @var Collection<int, Saving>
     */
    #[ORM\OneToMany(targetEntity: Saving::class, mappedBy: 'houseHold')]
    private Collection $savings;

    public function __construct()
    {
        $this->houseHoldUsers = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->expenses = new ArrayCollection();
        $this->incomes = new ArrayCollection();
        $this->savings = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getType(): ?UserSituation
    {
        return $this->type;
    }

    public function setType(UserSituation $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDistributionType(): ?BudgetRepartition
    {
        return $this->distributionType;
    }

    public function setDistributionType(BudgetRepartition $distributionType): static
    {
        $this->distributionType = $distributionType;

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

    /**
     * @return Collection<int, HouseHoldUser>
     */
    public function getHouseHoldUsers(): Collection
    {
        return $this->houseHoldUsers;
    }

    public function addHouseHoldUser(HouseHoldUser $houseHoldUser): static
    {
        if (!$this->houseHoldUsers->contains($houseHoldUser)) {
            $this->houseHoldUsers->add($houseHoldUser);
            $houseHoldUser->setUser($this);
        }

        return $this;
    }

    public function removeHouseHoldUser(HouseHoldUser $houseHoldUser): static
    {
        if ($this->houseHoldUsers->removeElement($houseHoldUser)) {
            // set the owning side to null (unless already changed)
            if ($houseHoldUser->getUser() === $this) {
                $houseHoldUser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setHouseHold($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getHouseHold() === $this) {
                $category->setHouseHold(null);
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
}
