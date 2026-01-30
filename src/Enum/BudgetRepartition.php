<?php

namespace App\Enum;

enum BudgetRepartition: string
{
    case FIFTY_FIFTY = '50_50';
    case PROPORTIONAL = 'proportionnel';
    case CUSTOM = 'personnalise';
}
