<?php

namespace App\Core\Repository\Master;

use App\Core\Interface\Master\UnitInterface;
use App\Models\Master\Unit;
use Illuminate\Support\Facades\DB;

class UnitRepository implements UnitInterface
{
    public function getAllUnit()
    {
        $results = Unit::select(DB::raw("id,code,name,status"))->get();
        return $results;
    }

    public function findUnitById($id)
    {
        $result = Unit::find($id);
        return $result;
    }

    public function createUnit($request)
    {
        return Unit::updateOrCreate([
                'id' => $request->unit_id
            ],
            [
                'code' => $request->code,
                'name' => $request->name,
            ]);
    }

    public function updateUnit($request, $id)
    {
        $result = Unit::find($id);
        $data = [
            'code' => $request->code,
            'name' => $request->name,
        ];
        $result->update($data);
        return $result;
    }

    public function suspendUnitById($id)
    {
        $result = Unit::find($id);
        $result->status = 'SUSPEND';
        $result->save();
        return $result;
    }
}
