<?php

namespace App\Policies\Master;

use App\Policies\VimaPermissionsPolicy;

class ItemPolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'items';
    }
}
