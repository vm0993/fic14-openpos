<?php

namespace App\Helpers;

class Helper
{
    public static function selectedPermissionsArray($permissions, $selected_arr = [])
    {
        $permissions_arr = [];

        foreach ($permissions as $permission) {
            for ($x = 0; $x < count($permission); $x++) {
                $permission_name = $permission[$x]['permission'];

                if ($permission[$x]['display'] === true) {
                    if ($selected_arr) {
                        if (array_key_exists($permission_name, $selected_arr)) {
                            $permissions_arr[$permission_name] = $selected_arr[$permission_name];
                        } else {
                            $permissions_arr[$permission_name] = '0';
                        }
                    } else {
                        $permissions_arr[$permission_name] = '0';
                    }
                }
            }
        }

        return $permissions_arr;
    }
}
