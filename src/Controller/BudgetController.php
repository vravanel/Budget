<?php

namespace App\Controller;

use App\Entity\Expense;
use App\Form\BudgetType;
use App\Entity\Household;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class BudgetController extends AbstractController
{
    #[Route('/budget', name: 'app_budget')]
    public function index(Request $request): Response
    {
        $houseHold = new Household();
        $expense = new Expense();

        $form = $this->createForm(BudgetType::class, $houseHold);

        return $this->render('budget/index.html.twig', [
            'form' => $form,
            'expense' => $expense
        ]);
    }
}
