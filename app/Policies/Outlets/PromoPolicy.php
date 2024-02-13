<?php

namespace App\Policies\Outlets;

use App\Policies\VimaPermissionsPolicy;

class PromoPolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'promos';
    }
}
