<?php

namespace App\Twig\Components;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

#[AsLiveComponent]
final class NewCategoryForm extends AbstractController
{
    use ComponentToolsTrait;
    use DefaultActionTrait;
    use ValidatableComponentTrait;

    #[LiveProp(writable: true)]
    #[NotBlank(message: 'Le nom de la catégorie est requis')]
    public string $name = '';

    #[LiveAction]
    public function saveCategory(EntityManagerInterface $entityManager): void
    {
        $this->validate();

        $user = $this->getUser();
        if (!$user instanceof \App\Entity\User) {
            return;
        }

        $houseHoldUsers = $user->getHouseHoldUsers();
        if ($houseHoldUsers->isEmpty()) {
            return;
        }

        $household = $houseHoldUsers->first()->getHouseHold();
        if (!$household) {
            return;
        }
        
        $category = new Category();
        $category->setName($this->name);
        $category->setIsDefault(false);
        $category->setCreatedAt(new \DateTime());
        $category->setHouseHold($household);

        $entityManager->persist($category);
        $entityManager->flush();

        $this->dispatchBrowserEvent('modal:close');
        $this->emit('category:created', [
            'category' => $category->getId(),
        ]);

        $this->name = '';
        $this->resetValidation();
    }
}
