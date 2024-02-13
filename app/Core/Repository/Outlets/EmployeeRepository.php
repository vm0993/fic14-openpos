<?php

namespace App\Core\Repository\Outlets;

use App\Core\Interface\Outlets\EmployeeInterface;
use App\Models\Master\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeRepository implements EmployeeInterface
{
    public function getAllEmployee($request)
    {
        $results = Employee::with('outlet');
        return $results;
    }

    public function findEmployeeById($id)
    {
        $result = Employee::find($id);
        return $result;
    }

    public function createEmployee($request)
    {
        $data = [
            'outlet_id' => $request->outlet_id,
            'code'      => $request->code,
            'name'      => $request->name,
            'phone_no'  => $request->phone_no,
            'address'   => $request->address,
            'email'     => $request->email,
        ];
        return Employee::create($data);
    }

    public function updateEmployee($request, $id)
    {
        $result = Employee::find($id);
        $data = [
            'outlet_id' => $request->outlet_id,
            'code'      => $request->code,
            'name'      => $request->name,
            'phone_no'  => $request->phone_no,
            'address'   => $request->address,
            'email'     => $request->email,
        ];
        $result->update($data);
        return $result;
    }

    public function suspendEmployeeById($id)
    {
        $result = Employee::find($id);
        $result->status = 'SUSPEND';
        $result->save();
        return $result;
    }
}
