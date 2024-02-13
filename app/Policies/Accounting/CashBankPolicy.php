<?php

namespace App\Policies\Accounting;

use App\Policies\VimaPermissionsPolicy;

class CashBankPolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'cash_banks';
    }
}
