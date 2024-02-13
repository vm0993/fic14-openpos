<?php

namespace App\Http\Controllers\Master;

use App\Core\Interface\Master\ItemInterface;
use App\Http\Controllers\Controller;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    use Response;
    protected ItemInterface $item;

    public function __construct(ItemInterface $item)
    {
        $this->middleware('auth');
        $this->item = $item;
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $results = $this->item->getAllItem();
            return datatables()
                ->of($results)
                ->editColumn('code', function ($row) {
                    if($row->status == 'AKTIF'){
                        $uriEdit = route('masters.item.edit',['item' => $row['id']]);
                        return '<a href="'.$uriEdit.'">
                        <span class="text-xs text-success whitespace-nowrap ml-4"><strong>'.$row->code.'</strong></span></a>';
                    }else{
                        return '<a href="javascript:void(0)">
                        <span class="text-xs text-danger whitespace-nowrap ml-4"><strong>'.$row->code.'</strong></span></a>';
                    }
                })
                ->editColumn('name', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.($row->name).'</span>';
                })
                ->addColumn('unit_name', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.($row->unit->name).'</span>';
                })
                ->addColumn('category_name', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.($row->category->name).'</span>';
                })
                ->editColumn('sale_amount', function ($row) {
                    return '<span class="text-xs whitespace-nowrap mr-4">'.number_format($row->sale_amount).'</span>';
                })
                ->editColumn('item_type', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.($row->item_type).'</span>';
                })
                ->editColumn('item_sale', function ($row) {
                    if($row->item_sale ==1){
                        return '<img src="'. asset("vendor/blade-lucide-icons/check-circle.svg") .'" class="w-4 h-4 ml-4"/>';
                    }else{
                        return '<img src="'. asset("vendor/blade-lucide-icons/x-circle.svg") .'" class="w-4 h-4 ml-4"/>';
                    }
                })
                ->editColumn('item_purchase', function ($row) {
                    if($row->item_purchase ==1){
                        return '<img src="'. asset("vendor/blade-lucide-icons/check-circle.svg") .'" class="w-4 h-4 ml-4"/>';
                    }else{
                        return '<img src="'. asset("vendor/blade-lucide-icons/x-circle.svg") .'" class="w-4 h-4 ml-4"/>';
                    }
                })
                ->editColumn('item_stock', function ($row) {
                    if($row->item_stock ==1){
                        return '<img src="'. asset("vendor/blade-lucide-icons/check-circle.svg") .'" class="w-4 h-4 ml-4"/>';
                    }else{
                        return '<img src="'. asset("vendor/blade-lucide-icons/x-circle.svg") .'" class="w-4 h-4 ml-4"/>';
                    }
                })
                ->editColumn('status', function ($row) {
                    return '<span class="text-xs whitespace-nowrap">'.($row->status).'</span>';
                })
                ->addColumn('action', function ($row) {
                    $uriSuspend = "";
                    if($row->item_purchase == 1){
                        return '<div class="flex justify-center items-center">
                                    <div class="intro-y flex flex-wrap sm:flex-nowrap items-center">
                                        <div class="dropdown">
                                            <button class="dropdown-toggle btn btn-sm px-2 box text-gray-700 dark:text-gray-300" data-tw-toggle="dropdown" aria-expanded="false">
                                                <img src="'. asset("vendor/blade-lucide-icons/more-vertical.svg") .'" class="w-4 h-4"/>
                                            </button>
                                            <div class="dropdown-menu w-56">
                                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                    <a href="javascript:;" class="flex items-center block p-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-blue rounded-md">
                                                        <img src="'. asset("vendor/blade-lucide-icons/eye-off.svg") .'" class="w-4 h-4 mr-2"/>
                                                        <span>Suspend</span>
                                                    </a>
                                                    <a href="javascript:;" class="flex items-center block p-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-blue rounded-md">
                                                        <img src="'. asset("vendor/blade-lucide-icons/shopping-cart.svg") .'" class="w-4 h-4 mr-2"/>
                                                        <span>View Stock</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    }else{
                        return '<div class="flex justify-center items-center">
                                    <div class="intro-y flex flex-wrap sm:flex-nowrap items-center">
                                        <div class="dropdown">
                                            <button class="dropdown-toggle btn btn-sm px-2 box text-gray-700 dark:text-gray-300" data-tw-toggle="dropdown" aria-expanded="false">
                                                <img src="'. asset("vendor/blade-lucide-icons/more-vertical.svg") .'" class="w-4 h-4"/>
                                            </button>
                                            <div class="dropdown-menu w-56">
                                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                    <a href="javascript:;" class="flex items-center block p-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-blue rounded-md">
                                                        <img src="'. asset("vendor/blade-lucide-icons/eye-off.svg") .'" class="w-4 h-4 mr-2"/>
                                                        <span>Suspend</span>
                                                    </a>
                                                    <a href="javascript:;" class="flex items-center block p-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-blue rounded-md">
                                                        <img src="'. asset("vendor/blade-lucide-icons/percent.svg") .'" class="w-4 h-4 mr-2"/>
                                                        <span>New Promos</span>
                                                    </a>
                                                    <a href="javascript:;" class="flex items-center block p-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-blue rounded-md">
                                                        <img src="'. asset("vendor/blade-lucide-icons/shopping-cart.svg") .'" class="w-4 h-4 mr-2"/>
                                                        <span>View Sales</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    }
                })
                ->rawColumns(['name','unit_name','code','category_name','sale_amount','item_sale','item_purchase','item_stock','item_type','status','action'])
                ->make(true);
        }
        return view('master.item.index');
    }

    public function create()
    {
        $title  = 'New Item';
        $result = "";
        return view('master.item.create',compact('title','result'));
    }

    public function generateItemNo(Request $request)
    {
        return $this->item->generateCodeByType($request);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->item->createItem($request);
            DB::commit();
            $notification = array(
                'message'    => 'Item successfull to saved!',
                'alert-type' => 'success'
            );
            return redirect()->route('masters.item.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message'    => $th->getMessage(),   //'Item failed to saved!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function show($id){}

    public function edit($id)
    {
        $title  = 'Edit Item';
        $result = $this->item->findItemById($id);
        return view('master.item.create',compact('title','result'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->item->updateItem($request, $id);
            DB::commit();
            $notification = array(
                'message' => 'Item successfull to updated!',
                'alert-type' => 'success'
            );
            return redirect()->route('masters.item.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message' => 'Item failed to updated!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function suspend($id)
    {

    }
}
