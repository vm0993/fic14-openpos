<?php

namespace App\Policies\Master;

use App\Policies\VimaPermissionsPolicy;

class UnitPolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'units';
    }
}
