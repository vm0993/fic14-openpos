<?php

namespace App\Core\Repository;

use App\Core\Interface\SetupInterface;
use App\Models\Master\Outlet;
use App\Models\Sistem\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SetupRepository implements SetupInterface
{
    public function prepareProfileUsahaAndUser($request)
    {
        $user              = new User();
        $user->name        = $request->name;
        $user->email       = $request->email;
        $user->password    = $request->password;

        $settings               = new Company();
        $settings->company_name = $request->nama_perusahaan;
        $settings->address      = $request->alamat;
        $settings->phone_no     = $request->no_telepon;
        $settings->website      = $request->website;

        $params = [
            'user'     => $user,
            'settings' => $settings,
        ];

        return $params;
    }

    public function storeProfileUsahaAndUser($boolean, $request)
    {
        //return $boolean;
        if($boolean == true){
            $settings               = new Company();
            $settings->company_name = $request->nama_perusahaan;
            $settings->address      = $request->alamat;
            $settings->phone_no     = $request->no_telepon;
            $settings->website      = $request->website;
            $settings->outlet_qty   = 1;

            $settings->save();

            $dataUser = [
                'name'                => $request->name,
                'email'               => $request->email,
                'password'            => $request->password,
                'permission_group_id' => 1,
                'company_id'          => $settings->id,
                'pegawai_id'          => 0,
                'activated'           => 1,
            ];
            $user = User::create($dataUser);

            //Save Outlet
            $outlet             = new Outlet();
            $outlet->company_id = $settings->id;
            $outlet->code       = $request->code;
            $outlet->name       = $request->nama_outlet;
            $outlet->email      = $request->email_outlet;
            $outlet->phone_no   = $request->telpon_outlet;
            $outlet->created_by = $user->id;
            $outlet->save();

            return $user;
        }
    }
}
