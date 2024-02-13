<?php

namespace App\Core\Repository\Settings;

use App\Core\Interface\Settings\ItemDefaultInterface;
use App\Models\Sistem\CompanyDefault;

class ItemDefaultRepository implements ItemDefaultInterface
{
    public function getItemDefault($company_id)
    {
        $default   = CompanyDefault::where('company_id',$company_id)->first();
        return $default;
    }

    public function createItemDefault($company_id, $request)
    {
        $data = [
            'company_id'                 => $company_id,
            'inventory_account_id'       => $request->inventory_account_id,
            'sales_account_id'           => $request->sales_account_id,
            'sales_return_account_id'    => $request->sales_return_account_id,
            'item_discount_account_id'   => $request->item_discount_account_id,
            'cogs_account_id'            => $request->cogs_account_id,
            'purchase_return_account_id' => $request->purchase_return_account_id,
            'expense_account_id'         => $request->expense_account_id,
            'unbill_account_id'          => $request->unbill_account_id
        ];

        return CompanyDefault::create($data);
    }

    public function updateItemDefault($company_id,$request, $id)
    {
        $default = CompanyDefault::find($id);
        $data = [
            'company_id'                 => $company_id,
            'inventory_account_id'       => $request->inventory_account_id,
            'sales_account_id'           => $request->sales_account_id,
            'sales_return_account_id'    => $request->sales_return_account_id,
            'item_discount_account_id'   => $request->item_discount_account_id,
            'cogs_account_id'            => $request->cogs_account_id,
            'purchase_return_account_id' => $request->purchase_return_account_id,
            'expense_account_id'         => $request->expense_account_id,
            'unbill_account_id'          => $request->unbill_account_id
        ];
        $default->update($data);
        return $default;
    }
}
