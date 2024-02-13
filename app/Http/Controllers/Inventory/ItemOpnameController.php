<?php

namespace App\Http\Controllers\Inventory;

use App\Core\Interface\Inventorys\ItemOpnameInterface;
use App\Http\Controllers\Controller;
use App\Response\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemOpnameController extends Controller
{
    use Response;
    protected ItemOpnameInterface $itemOpname;

    public function __construct(ItemOpnameInterface $itemOpname)
    {
        $this->middleware('auth');
        $this->itemOpname = $itemOpname;
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $results = $this->itemOpname->getAllOpnameItems($request);
            return datatables()
                ->of($results)
                ->editColumn('code', function ($data) {
                    $uriEdit = route('inventorys.item-opname.edit',['item_opname' => $data->id]);
                    return '<a href="'.$uriEdit.'"><span class="text-xs text-success whitespace-nowrap ml-4">'.$data->code.'</span></a>';
                })
                ->addColumn('outlet', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.($row->name).'</span>';
                })
                ->editColumn('transaction_date', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.Carbon::parse($row->transaction_date)->translatedFormat('d F Y').'</span>';
                })
                ->editColumn('description', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.$row->description.'</span>';
                })
                ->addColumn('addDetailUrl',function($row){
                    return route('inventorys.item-opname.detail',['id' => $row->id]);
                })
                ->editColumn('total_opname', function ($row) {
                    return '<span class="text-xs whitespace-nowrap mr-4">'.number_format($row->total_opname).'</span>';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="flex justify-center items-center">
                                <div class="intro-y flex flex-wrap sm:flex-nowrap items-center">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle btn btn-sm px-2 box text-gray-700 dark:text-gray-300" data-tw-toggle="dropdown" aria-expanded="false">
                                            <img src="'. asset("vendor/blade-lucide-icons/more-vertical.svg") .'" class="w-4 h-4"/>
                                        </button>
                                        <div class="dropdown-menu w-56">
                                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                <a href="javascript:;" class="flex items-center block p-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-blue rounded-md">
                                                    <img src="'. asset("vendor/blade-lucide-icons/edit-2.svg") .'" class="w-4 h-4 mr-2"/>
                                                    <span>Edit</span>
                                                </a>
                                                <a href="javascript:;" data-id="'.$data->id.'" id="deleteButton" data-modal-target="deleteModal" data-modal-toggle="deleteModal" class="flex items-center block p-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-blue rounded-md">
                                                    <img src="'. asset("vendor/blade-lucide-icons/trash-2.svg") .'" class="w-4 h-4 mr-2"/>
                                                    <span>Delete</span>
                                                </a>
                                                <a href="javascript:;" target="_blank" class="flex items-center block p-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-blue rounded-md">
                                                    <img src="'. asset("vendor/blade-lucide-icons/printer.svg") .'" class="w-4 h-4 mr-2"/>
                                                    <span>Preview PDF</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                })
                ->rawColumns(['code','outlet','transaction_date','description','total_opname','action'])
                ->make(true);
        }
        return view('inventorys.opnames.index');
    }

    public function getDetailByOpnameID(Request $request, $id)
    {
        if($request->ajax()){
            $results = $this->itemOpname->getDetailOpnameById($id);
            return datatables()
                ->of($results)
                ->editColumn('code', function ($data) {
                    return '<span class="text-xs text-success whitespace-nowrap">'.$data->code.'</span>';
                })
                ->editColumn('name', function ($data) {
                    return '<span class="text-xs text-theme-20 whitespace-nowrap">'.$data->name.'</span>';
                })
                ->editColumn('qty', function ($data) {
                    return '<span class="text-xs text-theme-20 whitespace-nowrap mr-2">'.number_format($data->qty,2).'</span>';
                })
                ->editColumn('buy_price',function($data){
                    return '<span class="text-xs text-theme-20 whitespace-nowrap mr-2">'.number_format($data->buy_price,2).'</span>';
                })
                ->addColumn('action',function($data){
                    return '<div class="flex justify-center items-center">
                                <div class="intro-y flex flex-wrap sm:flex-nowrap items-center">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" data-tw-toggle="dropdown" aria-expanded="false">
                                            <img src="'. asset("vendor/blade-lucide-icons/more-vertical.svg") .'" class="w-4 h-4"/>
                                        </button>
                                    </div>
                                </div>
                            </div>';
                })
                ->rawColumns(['code','name','qty','buy_price','action'])
                ->make(true);
        }
    }

    public function getDetailOpname($id)
    {
        return $this->itemOpname->getDetailOpnameById($id);
    }

    public function setOpnameNumber(Request $request)
    {
        return $this->itemOpname->getOpnameNo($request);
    }

    public function create()
    {
        $title  = 'New Item Opname';
        $result = "";
        $items  = getAllPurchaseItems();
        return view('inventorys.opnames.create',compact('title','result','items'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->itemOpname->createOpnameItems($request);
            DB::commit();
            $notification = array(
                'message'    => 'Item Opname successfull to saved!',
                'alert-type' => 'success'
            );
            return redirect()->route('inventorys.item-opname.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message'    => $th->getMessage(),   //'Item failed to saved!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function edit($id)
    {
        $title  = 'Edit Item Opname';
        $result = $this->itemOpname->findOpnameItemById($id);
        $items  = getAllPurchaseItems();
        return view('inventorys.opnames.create',compact('title','result','items'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->itemOpname->updateOpnameItems($request,$id);
            DB::commit();
            $notification = array(
                'message'    => 'Item Opname successfull to updated!',
                'alert-type' => 'success'
            );
            return redirect()->route('inventorys.item-opname.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message'    => $th->getMessage(),   //'Item failed to saved!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function destroy($id)
    {

    }
}
