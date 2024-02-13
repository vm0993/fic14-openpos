<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VimaModel extends Model
{
    use HasFactory;

    public function getDisplayNameAttribute()
    {
        return $this->name;
    }
}
