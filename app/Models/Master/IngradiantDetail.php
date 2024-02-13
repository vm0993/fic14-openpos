<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngradiantDetail extends Model
{
    use HasFactory;
    protected $guarded = array();

    public function ingradiant()
    {
        return $this->belongsTo(Ingradiant::class);
    }
}
