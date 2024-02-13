<?php

namespace App\Core\Repository\Outlets;

use App\Core\Interface\Outlets\PromoInterface;
use App\Models\Master\Promo;
use App\Models\Master\PromoDetail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PromoRepository implements PromoInterface
{
    public function getAllPromo($request)
    {
        $results = Promo::select(DB::raw("id,code,promo_type,voucher_qty,start_date,end_date,status"))->get();
        return $results;
    }

    public function getDetailPromoById($id)
    {
        $results = PromoDetail::select(DB::raw("promo_details.id,promo_details.promo_id,promo_details.voucher_promo,promo_details.status,promo_details.apply_date"))
            ->where('promo_details.promo_id',$id)
            ->get();
        return $results;
    }

    public function findPromoById($id)
    {
        $result = Promo::find($id);
        return $result;
    }

    public function createPromo($request)
    {
        $data = [
            'code'        => $request->code,
            'promo_type'  => $request->promo_type,
            'voucher_qty' => $request->voucher_qty,
            'start_date'  => Carbon::parse($request->start_date)->format('Y-m-d'),
            'end_date'    => Carbon::parse($request->end_date)->format('Y-m-d'),
        ];
        $promo = Promo::create($data);
        for ($i=1; $i <= $request->voucher_qty; $i++) {
            $detailVoucher = [
                'promo_id'      => $promo->id,
                'voucher_promo' => Str::upper(Str::random(6)),
            ];
            PromoDetail::create($detailVoucher);
        }
    }

    public function updatePromo($request, $id)
    {
        $result = Promo::find($id);
        $data = [
            'code'        => $request->code,
            'promo_type'  => $request->promo_type,
            'voucher_qty' => $request->voucher_qty,
            'start_date'  => Carbon::parse($request->start_date)->format('Y-m-d'),
            'end_date'    => Carbon::parse($request->end_date)->format('Y-m-d'),
        ];
        $result->update($data);
        return $result;
    }

    public function suspendPromoById($id)
    {
        $result = Promo::find($id);
        $result->status = 'SUSPEND';
        $result->save();
        return $result;
    }
}
