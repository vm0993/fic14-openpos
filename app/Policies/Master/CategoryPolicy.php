<?php

namespace App\Policies\Master;

use App\Policies\VimaPermissionsPolicy;

class CategoryPolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'categoris';
    }
}
