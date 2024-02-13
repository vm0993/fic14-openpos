<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions     = config('permission');
        $userPermissions = Helper::selectedPermissionsArray($permissions, []);
        $varArray = [];
        foreach ($userPermissions as $key => $permissionArray) {
            $varArray[]  = [
               $key => $key == 'admin' || $key == 'cashier' || $key == 'waiter' ? 0 : 1,
            ];
        }
        $group = [
            'name'       => 'Owner',
            'permission' => call_user_func_array('array_merge',$varArray),
        ];
        PermissionGroup::create($group);
    }

    private function filterDisplayable($permissions)
    {
        $output = null;
        foreach ($permissions as $key => $permission) {
            $output[$key] = array_filter($permission, function ($p) {
                return $p['display'] === true;
            });
        }

        return $output;
    }
}
