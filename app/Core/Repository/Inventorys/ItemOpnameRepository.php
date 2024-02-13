<?php

namespace App\Core\Repository\Inventorys;

use App\Core\Interface\Inventorys\ItemOpnameInterface;
use App\Models\Inventory\ItemOpname;
use App\Models\Inventory\ItemOpnameDetail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ItemOpnameRepository implements ItemOpnameInterface
{
    public function getAllOpnameItems($request)
    {
        $results = ItemOpname::select(DB::raw("item_opnames.id,item_opnames.code,item_opnames.transaction_date,item_opnames.description,item_opnames.outlet_id,outlets.name,item_opnames.total_opname"))
            ->join('outlets','outlets.id','=','item_opnames.outlet_id');
        //filter by date
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $results = $results->whereBetween('item_opnames.transaction_date', [$request->from_date, $request->to_date]);
        }
        return $results;
    }

    public function getOpnameNo($request)
    {
        $transaction_date = $request->transaction_date;
        $period           = Carbon::parse($transaction_date)->format('ym');
        $lastAccount      = ItemOpname::select(DB::raw('max(RIGHT(code, 4)) as result'))
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

        return 'OI'.Carbon::parse($transaction_date)->format('ym').$tmpNo;
    }

    public function findOpnameItemById($id)
    {
        $result = ItemOpname::find($id);
        return $result;
    }

    public function createOpnameItems($request)
    {
        $data = [
            'outlet_id'        => $request->outlet_id,
            'code'             => $request->code,
            'transaction_date' => Carbon::parse(Str::replace('_','',$request->transaction_date))->format('Y-m-d'),
            'description'      => $request->description,
        ];
        $result = ItemOpname::create($data);
        //save detail incoming item
        foreach (request('nomor') as $key => $count) {
            $qtyBarang = preg_replace( '/[^0-9.]/', '', request('qty_'.$count));
            $qtyOpname = preg_replace( '/[^0-9.]/', '', request('qty_opname_'.$count));
            $dataDetail = [
                'item_opname_id' => $result->id,
                'item_id'        => request('item_id_'.$count),
                'qty'            => $qtyBarang,
                'qty_opname'     => $qtyOpname,
            ];
            ItemOpnameDetail::create($dataDetail);
        }
        return $result;
    }

    public function updateOpnameItems($request, $id)
    {
        $result = ItemOpname::find($id);
        $data = [
            'outlet_id'        => $request->outlet_id,
            'code'             => $request->code,
            'transaction_date' => Carbon::parse(Str::replace('_','',$request->transaction_date))->format('Y-m-d'),
            'description'      => $request->description,
        ];
        $result->update($data);
        ItemOpnameDetail::where('item_opname_id',$id)->delete();
        //save detail incoming item
        foreach (request('nomor') as $key => $count) {
            $qtyBarang = preg_replace( '/[^0-9.]/', '', request('qty_'.$count));
            $qtyOpname = preg_replace( '/[^0-9.]/', '', request('qty_opname_'.$count));
            $dataDetail = [
                'item_opname_id' => $result->id,
                'item_id'        => request('item_id_'.$count),
                'qty'            => $qtyBarang,
                'qty_opname'     => $qtyOpname,
            ];
            ItemOpnameDetail::create($dataDetail);
        }
        return $result;
    }

    public function getDetailOpnameById($id)
    {
        $results = ItemOpnameDetail::select(DB::raw("item_opname_details.id,item_opname_details.item_id,items.code,items.name,item_opname_details.qty,item_opname_details.qty_opname"))
            ->join('items','items.id','=','item_incoming_details.item_id')
            ->where('item_opname_details.item_opname_id',$id)
            ->get();
        return $results;
    }
}
