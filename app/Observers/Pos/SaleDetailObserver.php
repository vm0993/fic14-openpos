<?php

namespace App\Observers\Pos;

use App\Models\Master\Tax;
use App\Models\POS\SaleDetail;

class SaleDetailObserver
{
    private function generateTotal($saleDetail)
    {
        $orderDetail   = SaleDetail::where('sale_id', $saleDetail->sale_id)->get();

        $orderAmount = $saleDetail->sum(function($i) {
            return ($i->qty * $i->sale_price);
        });

        $totalDiscount = $saleDetail->sum(function($i) {
            return (($i->qty * $i->sale_price)*($i->discount/100));
        });

        $totalSC = $saleDetail->sum(function($i) {
            $company       = getSetting();
            return (($i->qty * $i->sale_price) -(($i->qty * $i->sale_price)*($i->discount/100))) * ($company['service_charges_rate']/100);
        });

        $totalPB1 = $saleDetail->sum(function($i) {
            $company     = getSetting();
            $subTotOrder = (($i->qty * $i->sale_price) -(($i->qty * $i->sale_price)*($i->discount/100)));
            $servCharge  = $subTotOrder * ($company['service_charges_rate']/100);
            $totalPajak  = (($subTotOrder + $servCharge) * ($company['resto_tax_rate']/100));
            return $totalPajak;
        });

        $totalOrder = $saleDetail->sum(function($i) {
            $company        = getSetting();
            $subTotOrder    = (($i->qty * $i->sale_price) -(($i->qty * $i->sale_price)*($i->discount/100)));
            $servCharge     = $subTotOrder * ($company['service_charges_rate']/100);
            $totalPenjualan = ($subTotOrder + $servCharge) + (($subTotOrder + $servCharge) * ($company['resto_tax_rate']/100));
            return $totalPenjualan;
        });

        $saleDetail->jurnal()->update([
            'sub_total'            => $orderAmount,
            'discount_amount'      => $totalDiscount,
            'sevice_charge_amount' => $totalSC,
            'tax_amount'           => $totalPB1,
            'grand_total'          => $totalOrder,
        ]);
    }

    public function created(SaleDetail $saleDetail)
    {
        $this->generateTotal($saleDetail);
    }

    public function updated(SaleDetail $saleDetail)
    {
        $this->generateTotal($saleDetail);
    }

    public function deleted(SaleDetail $saleDetail)
    {
        $this->generateTotal($saleDetail);
    }
}
