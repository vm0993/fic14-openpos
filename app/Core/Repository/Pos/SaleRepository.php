<?php

namespace App\Core\Repository\Pos;

use App\Core\Interface\Pos\SaleInterface;
use App\Models\Master\Item;
use App\Models\POS\Sale;
use App\Models\POS\SaleDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SaleRepository implements SaleInterface
{
    public function getAllSales($request)
    {
        $results = Sale::select(DB::raw("sales.id,sales.outlet_id,outlets.name,sales.code,sales.transaction_date,sales.promo_id,sales.sub_total,sales.tax_amount,sales.grand_total,sales.type,sales.status"))
            ->join('outlets','outlets.id','=','sales.outlet_id');
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $results = $results->whereBetween('transaction_date', [$request->from_date, $request->to_date]);
        }
        return $results;
    }

    public function getDetailSalesById($id)
    {
        $results = SaleDetail::select(DB::raw("sale_details.id,sale_details.item_id,items.code,items.name,sale_details.qty,sale_details.sale_price,sale_details.price"))
            ->join('items','items.id','=','sale_details.item_id')
            ->where('sale_details.sale_id',$id)
            ->get();
        return $results;
    }

    private function getInvoiceNo()
    {
        $today = Carbon::now()->format('Y-m-d');
        $results = Sale::select(DB::raw("max(RIGHT(code, 3)) as result"))
            ->whereYear('transaction_date',Carbon::parse($today)->format('Y'))
            ->whereMonth('transaction_date',Carbon::parse($today)->format('m'))
            ->groupByRaw('date_format(transaction_date,"%y%m") = "'.Carbon::parse($today)->format('ym').'" ')
            ->orderBy('id','desc')
            ->first();

        if(!empty($results)){
            $lastNo = $results->result + 1;
        }else{
            $lastNo = 1;
        }
        $length_no = 3;
        $tmpNo = sprintf('%0'.$length_no.'s', $lastNo);
        return Carbon::parse($today)->format('ymd').$tmpNo;
    }

    public function storeSales($request)
    {

        $data = [
            'outlet_id'        => $request->outlet_id,
            'customer_id'      => $request->customer_id == 0 || $request->customer_id == null ? 0 : $request->customer_id,
            'code'             => $this->getInvoiceNo(),
            'transaction_date' => Carbon::now()->format('Y-m-d'),
            'promo_id'         => 0,
            'type'             => $request->type,
        ];
        $result  = Sale::create($data);
        $saleQty = preg_replace( '/[^0-9.]/', '', $request->qty);
        $item    = Item::find($request->item_id);
        $detailOrder = [
            'sale_id'    => $result->id,
            'item_id'    => $request->item_id,
            'qty'        => $saleQty,
            'sale_price' => $item->sale_amount,
            'discount'   => $request->discount == 0 || $request->discount == null ? 0 : $request->discount,
        ];
        SaleDetail::create($detailOrder);

        return $result;
    }

    public function updateSales($request, $id)
    {

    }
}
