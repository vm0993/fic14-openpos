<?php

namespace App\Policies;

use App\Models\Sistem\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class VimaPermissionsPolicy
{
    abstract protected function columnName();

    use HandlesAuthorization;

    public function before(User $user, $ability, $item)
    {
        // If an admin, they can do all asset related tasks.
        if ($user->hasAccess('superuser')) {
            return true;
        }
    }

    public function index(User $user)
    {
        return $user->hasAccess($this->columnName().'.view');
    }

    public function create(User $user)
    {
        return $user->hasAccess($this->columnName().'.create');
    }

    public function update(User $user, $item = null)
    {
        return $user->hasAccess($this->columnName().'.edit');
    }

    public function delete(User $user, $item = null)
    {
        $itemConditional = true;
        if ($item) {
            $itemConditional = empty($item->deleted_at);
        }

        return $itemConditional && $user->hasAccess($this->columnName().'.delete');
    }

    public function manage(User $user, $item = null)
    {
        return $user->hasAccess($this->columnName().'.edit');
    }
}
