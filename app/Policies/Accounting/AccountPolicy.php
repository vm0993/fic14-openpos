<?php

namespace App\Policies\Accounting;

use App\Policies\VimaPermissionsPolicy;

class AccountPolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'accounts';
    }
}
