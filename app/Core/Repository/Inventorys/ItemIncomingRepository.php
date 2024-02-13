<?php

namespace App\Core\Repository\Inventorys;

use App\Core\Interface\Inventorys\ItemIncomingInterface;
use App\Models\Inventory\ItemIncoming;
use App\Models\Inventory\ItemIncomingDetail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ItemIncomingRepository implements ItemIncomingInterface
{
    public function getAllIncomingItems($request)
    {
        $results = ItemIncoming::select(DB::raw("item_incomings.id,item_incomings.code,item_incomings.code as voucher,item_incomings.transaction_date,item_incomings.description,item_incomings.outlet_id,outlets.name,item_incomings.total_qty"))
            ->join('outlets','outlets.id','=','item_incomings.outlet_id');
        //filter by date
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $results = $results->whereBetween('item_incomings.transaction_date', [$request->from_date, $request->to_date]);
        }
        return $results;
    }

    public function getIncomingNo($request)
    {
        $transaction_date = $request->transaction_date;
        $period           = Carbon::parse($transaction_date)->format('ym');
        $lastAccount      = ItemIncoming::select(DB::raw('max(RIGHT(code, 4)) as result'))
            ->whereYear('transaction_date',Carbon::parse($transaction_date)->format('Y'))
            ->whereMonth('transaction_date',Carbon::parse($transaction_date)->format('m'))
            ->groupByRaw('date_format(transaction_date,"%y%m") = "'.$period.'" ')
            ->orderBy('id','desc')
            ->first();

        if(!empty($lastAccount)){
            $lastNo = $lastAccount->result + 1;
        }else{
            $lastNo = 1;
        }
        $length_no = 4;
        $tmpNo = sprintf('%0'.$length_no.'s', $lastNo);

        return 'RI'.Carbon::parse($transaction_date)->format('ym').$tmpNo;
    }

    public function getDetailIncomingById($id)
    {
        $results = ItemIncomingDetail::select(DB::raw("item_incoming_details.id,item_incoming_details.item_id,items.code,items.name,item_incoming_details.qty,item_incoming_details.buy_price,item_incoming_details.qty*item_incoming_details.buy_price as total"))
            ->join('items','items.id','=','item_incoming_details.item_id')
            ->where('item_incoming_details.item_incoming_id',$id)
            ->get();
        return $results;
    }

    public function findIncomingItemById($id)
    {
        $result = ItemIncoming::find($id);
        return $result;
    }

    public function createIncomingItems($request)
    {
        $data = [
            'outlet_id'        => $request->outlet_id,
            'code'             => $request->code,
            'transaction_date' => Carbon::parse(Str::replace('_','',$request->transaction_date))->format('Y-m-d'),
            'description'      => $request->description,
        ];
        $result = ItemIncoming::create($data);
        //save detail incoming item
        foreach (request('nomor') as $key => $count) {
            $qtyBarang   = preg_replace( '/[^0-9.]/', '', request('qty_'.$count));
            $hargaBarang = preg_replace( '/[^0-9.]/', '', request('buy_price_'.$count));
            $dataDetail = [
                'item_incoming_id' => $result->id,
                'item_id'          => request('item_id_'.$count),
                'qty'              => $qtyBarang,
                'buy_price'        => $hargaBarang,
            ];
            ItemIncomingDetail::create($dataDetail);
        }
        return $result;
    }

    public function updateIncomingItems($request, $id)
    {
        $result = ItemIncoming::find($id);
        $data = [
            'outlet_id'        => $request->outlet_id,
            'code'             => $request->code,
            'transaction_date' => Carbon::parse(Str::replace('_','',$request->transaction_date))->format('Y-m-d'),
            'description'      => $request->description,
        ];
        $result->update($data);
        //Delete old record
        ItemIncomingDetail::where('item_incoming_id',$id)->delete();
        //save detail incoming item
        foreach (request('nomor') as $key => $count) {
            $qtyBarang   = preg_replace( '/[^0-9.]/', '', request('qty_'.$count));
            $hargaBarang = preg_replace( '/[^0-9.]/', '', request('buy_price_'.$count));
            $dataDetail = [
                'item_incoming_id' => $result->id,
                'item_id'          => request('item_id_'.$count),
                'qty'              => $qtyBarang,
                'buy_price'        => $hargaBarang,
            ];
            ItemIncomingDetail::create($dataDetail);
        }
        return $result;
    }

    public function getDetailIncomingItemById($id)
    {

    }
}
