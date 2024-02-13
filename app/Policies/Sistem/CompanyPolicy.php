<?php

namespace App\Policies\Sistem;

use App\Policies\VimaPermissionsPolicy;

class CompanyPolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'companies';
    }
}
