<?php

namespace App\Models\Inventory;

use App\Models\Master\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemIncomingDetail extends Model
{
    use HasFactory;
    protected $guarded = array();

    public function incomingHeader()
    {
        return $this->belongsTo(ItemIncoming::class,'item_incoming_id','id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
