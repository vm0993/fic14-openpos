<?php

namespace App\Observers\Inventory;

use App\Models\Inventory\ItemIncomingDetail;

class ItemIncomingDetailObserver
{
    private function generateTotal($itemIncomingDetail)
    {
        $details   = ItemIncomingDetail::where('item_incoming_id', $itemIncomingDetail->item_incoming_id)->get();

        $totalQty = $details->sum(function($i) {
            return $i->qty;
        });

        $itemIncomingDetail->incomingHeader()->update([
            'total_qty' => $totalQty
        ]);
    }

    public function created(ItemIncomingDetail $itemIncomingDetail)
    {
        $this->generateTotal($itemIncomingDetail);
    }

    public function updated(ItemIncomingDetail $itemIncomingDetail)
    {
        $this->generateTotal($itemIncomingDetail);
    }

    public function deleted(ItemIncomingDetail $itemIncomingDetail)
    {
        $this->generateTotal($itemIncomingDetail);
    }
}
