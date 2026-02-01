<?php

namespace App\Twig\Components;

use DateTime;
use App\Entity\Expense;
use App\Entity\Category;
use App\Form\ExpenseType;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

#[AsLiveComponent]
final class ExpenseForm extends AbstractController
{
    use DefaultActionTrait;
    use LiveCollectionTrait;
    use ValidatableComponentTrait;

    public function __construct(private CategoryRepository $categoryRepository) {}

    #[LiveProp(fieldName: 'formData')]
    public ?Expense $expense = null;

    #[LiveProp(writable: true)]
    public string $name = '';

    #[LiveProp(writable: true)]
    public string $createdAt;

    #[LiveProp(writable: true)]
    #[NotBlank]
    public ?Category $category = null;

    public function mount(): void
    {
        if ($this->expense === null) {
            $this->expense = new Expense();
        }

        if (empty($this->createdAt)) {
            $this->createdAt = (new \DateTime())->format('Y-m-d');
        }
    }

    /**
     * @return list<Category>
     */
    #[ExposeInTemplate]
    public function getCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    #[LiveListener('category:created')]
    public function onCategoryCreated(#[LiveArg] Category $category): void
    {
        $this->category = $category;
    }

    public function isCurrentCategory(Category $category): bool
    {
        return $this->category && $this->category === $category;
    }

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager): Response
    {
        $this->validate();

        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour créer une dépense.');
            return $this->redirectToRoute('app_login');
        }

        $household = $user->getHouseHoldUsers();
        if (!$household) {
            $this->addFlash('error', 'Aucun foyer associé à votre compte.');
            return $this->redirectToRoute('app_budget');
        }

        $expense = new Expense();
        $expense->setLabel($this->name);
        $expense->setUser($user);
        $expense->setAmount('0.00'); 
        $expense->setType('expense');
        $expense->setDate(!empty($this->createdAt) ? new \DateTime($this->createdAt) : new \DateTime());
        $expense->setCreatedAt(new \DateTime());
        $expense->setCategory($this->category);
        $expense->setHouseHold($household);

        $entityManager->persist($expense);
        $entityManager->flush();

        $this->addFlash('success', 'Dépense enregistrée avec succès !');

        $this->name = '';
        $this->createdAt = (new \DateTime())->format('Y-m-d');
        $this->category = null;
        $this->resetValidation();

        return $this->redirectToRoute('app_budget');
    }

    /**
     * @return FormInterface<Expense>
     */
    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(
            ExpenseType::class,
            $this->expense
        );
    }
}
