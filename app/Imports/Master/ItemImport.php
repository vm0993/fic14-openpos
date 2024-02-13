<?php

namespace App\Imports\Master;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ItemImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }
}
