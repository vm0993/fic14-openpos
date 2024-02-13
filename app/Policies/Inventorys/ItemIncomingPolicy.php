<?php

namespace App\Policies\Inventorys;

use App\Policies\VimaPermissionsPolicy;

class ItemIncomingPolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'item_incomings';
    }
}
