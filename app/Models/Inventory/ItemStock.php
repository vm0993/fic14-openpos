<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

class ItemStock extends Model
{
    use HasFactory;
    protected $guarded = array();

}
