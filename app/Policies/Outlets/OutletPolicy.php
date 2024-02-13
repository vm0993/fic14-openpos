<?php

namespace App\Policies\Outlets;

use App\Policies\VimaPermissionsPolicy;

class OutletPolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'outlets';
    }
}
