<?php

namespace App\Core\Repository\Outlets;

use App\Core\Interface\Outlets\OutletEmployeeInterface;
use App\Core\Interface\Outlets\OutletInterface;
use App\Models\Master\Employee;
use App\Models\Master\Outlet;
use App\Models\Sistem\Company;
use Illuminate\Support\Facades\DB;

class OutletRepository implements OutletEmployeeInterface
{
    public function getAllOutlet($request)
    {
        $result = Outlet::with('employee');
        return $result;
    }

    public function getOutletEmployeeDetails($id)
    {
        $results = Employee::where('outlet_id',$id)->get();
        return $results;
    }

    public function findOutletById($id)
    {
        $result = Outlet::find($id);
        return $result;
    }

    public function createOutlet($request)
    {
        if($request->id == null){
            $data = [
                'company_id' => $request->company_id,
                'code'       => $request->code,
                'name'       => $request->name,
                'address'    => $request->address,
                'phone_no'   => $request->phone_no,
                'email'      => $request->email,
            ];
            //dd($data);
            $outlet  = Outlet::create($data);
            $company = Company::find($request->company_id);
            $company->outlet_qty = Outlet::count();
            $company->save();
            return $outlet;
        }else{
            $result = Outlet::find($request->id);
            $data = [
                'code'       => $request->code,
                'name'       => $request->name,
                'address'    => $request->address,
                'phone_no'   => $request->phone_no,
                'email'      => $request->email,
            ];
            $result->update($data);
            return $result;
        }
    }

    public function updateOutlet($request, $id)
    {
        $result = Outlet::find($id);
        $data = [
            'code'       => $request->code,
            'name'       => $request->name,
            'address'    => $request->address,
            'phone_no'   => $request->phone_no,
            'email'      => $request->email,
        ];
        $result->update($data);
        return $result;
    }

    public function suspendOutletById($id)
    {
        $result = Outlet::find($id);
        $result->status = 'SUSPEND';
        $result->save();
        return $result;
    }
}
