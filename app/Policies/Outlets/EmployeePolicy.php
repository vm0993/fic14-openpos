<?php

namespace App\Policies\Outlets;

use App\Policies\VimaPermissionsPolicy;

class EmployeePolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'employees';
    }
}
