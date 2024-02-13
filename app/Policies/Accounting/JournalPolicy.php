<?php

namespace App\Policies\Accounting;

use App\Policies\VimaPermissionsPolicy;

class JournalPolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'jurnals';
    }
}
