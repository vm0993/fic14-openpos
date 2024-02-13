<?php

namespace App\Policies\Master;

use App\Policies\VimaPermissionsPolicy;

class CustomerPolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'customers';
    }
}
