<?php

namespace App\Observers\Master;

use App\Models\Master\IngradiantDetail;

class IngradiantDetailObserver
{
    private function generateTotal($ingradiantDetail)
    {
        $details   = IngradiantDetail::where('ingradiant_id', $ingradiantDetail->ingradiant_id)->get();

        $totalCost = $details->sum(function($i) {
            return $i->cost_usage;
        });

        $ingradiantDetail->ingradiant()->update([
            'cost_amount' => $totalCost
        ]);
    }

    public function created(IngradiantDetail $ingradiantDetail)
    {
        $this->generateTotal($ingradiantDetail);
    }

    public function updated(IngradiantDetail $ingradiantDetail)
    {
        $this->generateTotal($ingradiantDetail);
    }

    public function deleted(IngradiantDetail $ingradiantDetail)
    {
        $this->generateTotal($ingradiantDetail);
    }
}
