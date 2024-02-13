<?php

namespace App\Models\Master;

use App\Models\Keuangan\Account;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Watson\Validating\ValidatingTrait;

class Tax extends Model
{
    use HasFactory;
    protected $guarded = array();

    public function purchaseAccount()
    {
        return $this->belongsTo(Account::class,'purchase_account_id','id');
    }

    public function salesAccount()
    {
        return $this->belongsTo(Account::class,'sale_account_id','id');
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
