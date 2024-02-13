<?php

namespace App\Policies\Sistem;

use App\Policies\VimaPermissionsPolicy;

class UserPolicy extends VimaPermissionsPolicy
{
    protected function columnName()
    {
        return 'users';
    }
}
