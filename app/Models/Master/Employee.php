<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Watson\Validating\ValidatingTrait;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = array();

    public function outlet()
    {
        return $this->belongsTo(\App\Models\Master\Outlet::class,'outlet_id','id');
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
