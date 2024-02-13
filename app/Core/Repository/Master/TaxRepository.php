<?php

namespace App\Core\Repository\Master;

use App\Core\Interface\Master\TaxInterface;
use App\Models\Master\Tax;
use Illuminate\Support\Facades\DB;

class TaxRepository implements TaxInterface
{
    public function getAllTaxes()
    {
        $results = Tax::select(DB::raw("id,code,description,tax_rate,status,
        (select account_name from accounts where id=taxes.purchase_account_id) as purchase,
        (select account_name from accounts where id=taxes.sale_account_id) as sales"));
        return $results;
    }

    public function findTaxById($id)
    {
        $result = Tax::find($id);
        return $result;
    }

    public function createTax($request)
    {
        $taxRate = preg_replace( '/[^0-9.]/', '', $request->tax_rate );
        $data = [
            'code'                => $request->code,
            'description'         => $request->description,
            'tax_rate'            => $taxRate,
            'sale_account_id'     => $request->sale_account_id,
            'purchase_account_id' => $request->purchase_account_id,
        ];
        return Tax::create($data);
    }

    public function updateTax($request, $id)
    {
        $result = Tax::find($id);
        $data = [
            'code'                => $request->code,
            'description'         => $request->description,
            'tax_rate'            => $request->tax_rate,
            'sale_account_id'     => $request->sale_account_id,
            'purchase_account_id' => $request->purchase_account_id,
        ];
        $result->update($data);
        return $result;
    }

    public function suspendTax($id)
    {
        $result = Tax::find($id);
        $result->status = 'SUSPEND';
        $result->save();
        return $result;
    }
}
