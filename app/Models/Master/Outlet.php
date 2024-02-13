<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Watson\Validating\ValidatingTrait;

class Outlet extends Model
{
    use HasFactory;
    protected $guarded = array();

    protected $rules = [
        'company_id' => 'required',
        'name'       => 'required|string|min:1|max:191',
        'code'       => 'required|min:4',
        'email'      => 'email|nullable|max:191',
    ];

    public function company()
    {
        return $this->hasOne(\App\Models\Sistem\Company::class,'company_id','id');
    }

    public function employee()
    {
        return $this->hasMany(Employee::class,'outlet_id');
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
