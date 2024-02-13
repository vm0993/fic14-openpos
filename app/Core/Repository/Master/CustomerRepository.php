<?php

namespace App\Core\Repository\Master;

use App\Core\Interface\Master\CustomerInterface;
use App\Models\Master\Customer;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements CustomerInterface
{
    public function getAllCustomer()
    {
        $results = Customer::select(DB::raw("id,name,phone_no,shop_amount"));
        return $results;
    }

    public function findCustomerById($id)
    {
        $result = Customer::find($id);
        return $result;
    }

    public function createCustomer($request)
    {
        $data = [
            'name'     => $request->name,
            'phone_no' => $request->phone_no,
        ];
        return Customer::create($data);
    }

    public function updateCustomer($request, $id)
    {
        $result = Customer::find($id);
        $data = [
            'name'     => $request->name,
            'phone_no' => $request->phone_no,
        ];
        $result->update($data);
        return $result;
    }

    public function suspendCustomerById($id)
    {
        $result = Customer::find($id);
        $result->status = 'SUSPEND';
        $result->save();
        return $result;
    }
}
