<?php

namespace App\Core\Repository\Master;

use App\Core\Interface\Master\CategoryInterface;
use App\Models\Master\Categori;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryInterface
{
    public function getAllCategory()
    {
        $results = Categori::select(DB::raw("id,name,show_pos,status"))->get();
        return $results;
    }

    public function findCategoryById($id)
    {
        $result = Categori::find($id);
        return $result;
    }

    public function createCategory($request)
    {
        return Categori::updateOrCreate([
            'id' => $request->category_id
        ],
        [
            'name'     => $request->name,
            'show_pos' => $request->show_pos == 'on' ? 'YA' : 'TIDAK' ,
        ]);
    }

    public function updateCategory($request, $id)
    {
        $result = Categori::find($id);
        $data = [
            'name'     => $request->name,
            'show_pos' => $request->show_pos == 'on' ? 'YA' : 'TIDAK' ,
        ];
        $result->update($data);
        return $result;
    }

    public function suspendCategoryById($id)
    {
        $result = Categori::find($id);
        $result->status = 'SUSPEND';
        $result->save();
        return $result;
    }
}
