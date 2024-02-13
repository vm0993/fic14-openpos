<?php

namespace App\Models\Inventory;

use App\Models\Master\Outlet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Watson\Validating\ValidatingTrait;

class ItemIncoming extends Model
{
    use HasFactory;
    protected $guarded = array();

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function itemIncomingDetail()
    {
        return $this->hasMany(ItemIncomingDetail::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
