<?php

namespace App\Policies\Master;

use App\Policies\VimaPermissionsPolicy;

class TaxPolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'taxes';
    }
}
