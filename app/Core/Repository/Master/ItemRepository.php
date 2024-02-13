<?php

namespace App\Core\Repository\Master;

use App\Core\Interface\Master\ItemInterface;
use App\Models\Master\Categori;
use App\Models\Master\Item;
use App\Models\Master\Outlet;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ItemRepository implements ItemInterface
{
    public function getAllItem()
    {
        $results = Item::with(['category','unit']);
        return $results;
    }

    public function generateCodeByType($request)
    {
        $category = Categori::find($request->categori_id);
        $result   = Item::select(DB::raw("max(RIGHT(code, 3)) as result"))
            ->where('categori_id',$request->categori_id)
            ->groupBy('categori_id')
            ->orderBy('id','desc')->first();
        if($result){
            $lastNo = $result->result + 1;
        }else{
            $lastNo = 1;
        }
        $length_no = 3;
        $tmpNo     = sprintf('%0'.$length_no.'s', $lastNo);
        return substr($category->name,0,1).$tmpNo;
    }

    public function getRawMaterialItems()
    {
        $results = Item::where('item_sale',0)->get();
        return $results;
    }

    public function findItemById($id)
    {
        $result = Item::find($id);
        return $result;
    }

    public function createItem($request)
    {
        $hargaJual = preg_replace( '/[^0-9.]/', '', $request->sale_amount );
        $ftMakanan = $request->file_upload;
        //dd($image);
        if($ftMakanan){
            $input['file'] = time().'.'.$ftMakanan->getClientOriginalExtension();
            //$destinationPath = public_path('/menu');
            $destinationPath = storage_path('/app/public/menus');

            !is_dir($destinationPath) && mkdir($destinationPath, 0777, true);

            $imgFile = Image::make($ftMakanan->getRealPath());

            $imgFile->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['file']);
        }else{
            $input['file'] = "";
        }
        $outlet = Outlet::count();

        $data = [
            //'outlet_id'       => $request->outlet_id,
            'categori_id'     => $request->categori_id,
            'code'            => $request->code,
            'name'            => $request->name,
            'sale_amount'     => $hargaJual,
            'unit_id'         => $request->unit_id,
            'item_image'      => $input['file'] == null ? '' : 'storage/menus/'.$input['file'],
            'sku'             => $request->sku,
            'barcode'         => $request->barcode,
            'item_purchase'   => $request->item_purchase == 'on' ? 1 : 0,
            'item_sale'       => $request->item_sale == 'on' ? 1 : 0,
            'item_stock'      => $request->item_stock == 'on' ? 1 : 0,
            'check_inventory' => $request->check_inventory == 'on' ? 1 : 0,
            'item_type'       => $request->item_type,
        ];
        $result = Item::create($data);
        if($request->item_type == 'KOMPOSISI'){
            $ingradiant = [
                //'item_id' => $re
            ];
        }
        return $result;
    }

    public function updateItem($request, $id)
    {
        $hargaJual = preg_replace( '/[^0-9.]/', '', $request->sale_amount );
        $data = [
            //'outlet_id'       => $request->outlet_id,
            'categori_id'     => $request->categori_id,
            'code'            => $request->code,
            'name'            => $request->name,
            'sale_amount'     => $hargaJual,
            'unit_id'         => $request->unit_id,
            'sku'             => $request->sku,
            'barcode'         => $request->barcode,
            'item_purchase'   => $request->item_purchase == 'on' ? 1 : 0,
            'item_sale'       => $request->item_sale == 'on' ? 1 : 0,
            'item_stock'      => $request->item_stock == 'on' ? 1 : 0,
            'check_inventory' => $request->check_inventory == 'on' ? 1 : 0,
            'item_type'       => $request->item_type,
        ];
        $result = Item::find($id);
        $result->update($data);
        if($request->hasFile('file_upload')){
            $ftMakanan     = $request->file('file_upload');
            $input['file'] = time().'.'.$ftMakanan->getClientOriginalExtension();
            //$destinationPath = public_path('/menu');
            $destinationPath = storage_path('/app/public/menus');

            !is_dir($destinationPath) && mkdir($destinationPath, 0777, true);

            $imgFile = Image::make($ftMakanan->getRealPath());

            $imgFile->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['file']);

            $imageUpdate = [
                'item_image'      => $input['file'] == null ? '' : 'storage/menus/'.$input['file'],
            ];
            $result->update($imageUpdate);
        }
        return $result;
    }

    public function suspendItemById($id)
    {
        $result = Item::find($id);
        $result->status = 'SUSPEND';
        return $result;
    }
}
