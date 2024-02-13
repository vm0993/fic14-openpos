<?php

namespace App\Policies\Inventorys;

use App\Policies\VimaPermissionsPolicy;

class ItemOpnamePolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'item_opnames';
    }
}
