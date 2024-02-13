<?php

namespace App\Core\Repository\Master;

use App\Core\Interface\Master\IngradiantInterface;
use App\Models\Master\Ingradiant;
use App\Models\Master\IngradiantDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IngradiantRepository implements IngradiantInterface
{
    public function getAllIngradiant()
    {
        $results = Ingradiant::orderBy('id','desc');
        return $results;
    }

    public function generateCode()
    {
        $transaction_date = Carbon::now();
        $result = Ingradiant::select(DB::raw('max(RIGHT(code, 4)) as result'))
            ->whereYear('created_at',Carbon::parse($transaction_date)->format('Y'))
            ->whereMonth('created_at',Carbon::parse($transaction_date)->format('m'))
            ->groupByRaw('date_format(created_at,"%y%m") = "'.Carbon::parse($transaction_date)->format('ym').'" ')
            ->orderBy('id','desc')
            ->first();
        if(!empty($result)){
            $lastNo = $result->result + 1;
        }else{
            $lastNo = 1;
        }
        $length_no = 4;
        $tmpNo = sprintf('%0'.$length_no.'s', $lastNo);
        return 'BOM'.Carbon::parse($transaction_date)->format('ym').$tmpNo;
    }

    public function findIngradiantById($id)
    {
        $result = Ingradiant::find($id);
        return $result;
    }

    public function getById($id)
    {
        $results = IngradiantDetail::select(DB::raw("ingradiant_details.id,ingradiant_details.item_id,items.code,items.name,ingradiant_details.qty_usage,ingradiant_details.cost_usage,ingradiant_details.note"))
            ->join('items','items.id','=','ingradiant_details.item_id')
            ->where('ingradiant_details.ingradiant_id',$id)
            ->get();
        return $results;
    }

    public function createIngradiant($request)
    {
        $data = [
            'code'        => $this->generateCode(),
            'description' => $request->description,
        ];
        $ingradiant = Ingradiant::create($data);
        foreach (request('nomor') as $key => $count) {
            $qtyUsage  = preg_replace( '/[^0-9.]/', '', request('qty_usage_'.$count));
            $costUsage = preg_replace( '/[^0-9.]/', '', request('cost_usage_'.$count));
            $dataDetail = [
                'ingradiant_id' => $ingradiant->id,
                'item_id'       => request('item_id_'.$count),
                'qty_usage'     => $qtyUsage,
                'cost_usage'    => $costUsage,
                'note'          => request('note_'.$count),
            ];
            IngradiantDetail::create($dataDetail);
        }
        return $ingradiant;
    }

    public function updateIngradiant($request, $id)
    {
        $ingradiant = Ingradiant::find($id);
        $data = [
            'code'        => $request->code,
            'description' => $request->description,
        ];
        $ingradiant->update($data);
        IngradiantDetail::where('ingradiant_id',$id)->delete();
        foreach (request('nomor') as $key => $count) {
            $qtyUsage  = preg_replace( '/[^0-9.]/', '', request('qty_usage_'.$count));
            $costUsage = preg_replace( '/[^0-9.]/', '', request('cost_usage_'.$count));
            $dataDetail = [
                'ingradiant_id' => $id,
                'item_id'       => request('item_id_'.$count),
                'qty_usage'     => $qtyUsage,
                'cost_usage'    => $costUsage,
                'note'          => request('note_'.$count),
            ];
            IngradiantDetail::create($dataDetail);
        }
    }

    public function suspendIngradiantById($id)
    {

    }
}
