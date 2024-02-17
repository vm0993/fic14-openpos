<?php

namespace App\Core\Repository\Settings;

use App\Core\Interface\Settings\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
    public function getUsers()
    {
        $results = User::select(DB::raw("users.id,users.name,users.email,users.user_type,permission_groups.name as permission_name"))
            ->join('permission_groups','permission_groups.id','=','users.permission_group_id')
            ->get();
        return $results;
    }

    public function findUserById($id)
    {
        $result = User::find($id);
        return $result;
    }

    public function createUserByPermission($id, $request)
    {
        $data = [
            'name'                => $request->name,
            'email'               => $request->email,
            'company_id'          => auth()->user()->company_id,
            'permission_group_id' => $request->group_permission_id,
            'pegawai_id'          => $request->pegawai_id,
            'password'            => $request->password,
            'user_type'           => $request->user_type,
            'activated'           => 1,
        ];
        return User::create($data);
    }

    public function createUser($request)
    {
        $data = [
            'name'                => $request->name,
            'email'               => $request->email,
            'company_id'          => auth()->user()->company_id,
            'permission_group_id' => $request->group_permission_id,
            'pegawai_id'          => $request->pegawai_id,
            'password'            => $request->password,
            'user_type'           => $request->user_type,
            'activated'           => 1,
        ];
        return User::create($data);
    }

    public function updateUser($request, $id)
    {
        $user = User::find($id);
        $data = [
            'name'                => $request->name,
            'email'               => $request->email,
            'company_id'          => auth()->user()->company_id,
            'permission_group_id' => $request->group_permission_id,
            'pegawai_id'          => $request->pegawai_id,
            'user_type'           => $request->user_type,
            'activated'           => 1,
        ];
        $user->update($data);
        return $user;
    }

    public function suspendUser($id)
    {
        $user = User::find($id);
        //$user->status =
    }
}
