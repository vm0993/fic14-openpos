<?php

namespace App\Core\Repository\Settings;

use App\Core\Interface\Settings\PermissionGroupInterface;
use App\Models\PermissionGroup;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PermissionGroupRepository implements PermissionGroupInterface
{
    public function getPermissionGroup()
    {
        $results = PermissionGroup::select('id','name','permission','status');
        return $results;
    }

    public function findPermissionGroupById($id)
    {
        $result = PermissionGroup::find($id);
        return $result;
    }

    public function getPermissionDetailById($id)
    {
        $results = User::select(DB::raw("id,name,email,user_type"))
            ->where('permission_group_id',$id)
            ->get();
        return $results;
    }

    public function createPermissionGroup($request)
    {
        $permission = json_encode($request->input('permission'));
        $data = [
            'name'       => $request->name,
            'permission' => json_decode($permission),
        ];
        $result = PermissionGroup::create($data);
        return $result;
    }

    public function updatePermissionGroup($request, $id)
    {
        $result = PermissionGroup::find($id);
        $permission = json_encode($request->input('permission'));
        $data = [
            'name'       => $request->name,
            'permission' => json_decode($permission),
        ];
        $result->update($data);
        return $result;
    }

    public function suspendPermissionGroup($id)
    {
        $result = PermissionGroup::find($id);
        $result->status = 'SUSPEND';
        $result->save();
        return $result;
    }
}
