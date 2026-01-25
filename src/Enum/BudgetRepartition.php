<?php

namespace src\Enum;

enum BudgetRepartition: string
{
    case FIFTY_FIFTY = '50_50';
    case PROPORTIONAL = 'proportionnel';
    case FIXED = 'fixe';
    case CUSTOM = 'personnalise';
}
