<?php

namespace App\Http\Controllers\Master;

use App\Core\Interface\Master\IngradiantInterface;
use App\Http\Controllers\Controller;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class IngradiantController extends Controller
{
    use Response;
    protected IngradiantInterface $ingradiant;

    public function __construct(IngradiantInterface $ingradiant)
    {
        $this->middleware('auth');
        $this->ingradiant = $ingradiant;
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $results = $this->ingradiant->getAllIngradiant();
            return datatables()
            ->of($results)
            ->editColumn('code', function ($row) {
                $uriEdit = route('masters.ingradiant.edit',['ingradiant' => $row->id ]);
                return '<a href="'.$uriEdit.'"><span class="text-xs text-success whitespace-nowrap ml-4">'.$row->code.'</span></a>';
            })
            ->addColumn('addDetailUrl',function($data){
                return route('masters.ingradiant.details',['id' => $data['id']]);
            })
            ->editColumn('cost_amount', function ($row) {
                return '<span class="text-xs whitespace-nowrap mr-4">'.number_format($row->cost_amount).'</span>';
            })
            ->addColumn('action', function ($data) {
                $uriEdit    = "";
                $uriDelete  = "";
                $uriVoucher = "";
                return '<div class="flex justify-center items-center">
                            <div class="intro-y flex flex-wrap sm:flex-nowrap items-center">
                                <div class="dropdown">
                                    <button class="dropdown-toggle btn btn-sm px-2 box text-gray-700 dark:text-gray-300" data-tw-toggle="dropdown" aria-expanded="false">
                                        <img src="'. asset("vendor/blade-lucide-icons/more-vertical.svg") .'" class="w-4 h-4"/>
                                    </button>
                                    <div class="dropdown-menu w-56">
                                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                            <a href="'.$uriEdit.'" class="flex items-center block p-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-blue rounded-md">
                                                <img src="'. asset("vendor/blade-lucide-icons/edit-2.svg") .'" class="w-4 h-4 mr-2"/>
                                                <span>Edit</span>
                                            </a>
                                            <a href="javascript:;" data-id="'.$data->id.'" id="deleteButton" data-modal-target="deleteModal" data-modal-toggle="deleteModal" class="flex items-center block p-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-blue rounded-md">
                                                <img src="'. asset("vendor/blade-lucide-icons/trash-2.svg") .'" class="w-4 h-4 mr-2"/>
                                                <span>Delete</span>
                                            </a>
                                            <a href="'.$uriVoucher.'" target="_blank" class="flex items-center block p-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-blue rounded-md">
                                                <img src="'. asset("vendor/blade-lucide-icons/printer.svg") .'" class="w-4 h-4 mr-2"/>
                                                <span>Preview PDF</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            })
            ->rawColumns(['code','cost_amount','action'])
            ->make(true);
        }
        return view('master.ingradiant.index');
    }

    public function getDetailIngradiant(Request $request, $id)
    {
        if($request->ajax()){
            $results = $this->ingradiant->getById($id);
            return datatables()
                ->of($results)
                ->editColumn('code', function ($data) {
                    return '<span class="text-xs text-success whitespace-nowrap">'.$data->code.'</span>';
                })
                ->editColumn('name', function ($data) {
                    return '<span class="text-xs text-theme-20 whitespace-nowrap">'.$data->name.'</span>';
                })
                ->editColumn('qty_usage', function ($data) {
                    return '<span class="text-xs text-theme-20 whitespace-nowrap mr-4">'.number_format($data->qty_usage,4).'</span>';
                })
                ->editColumn('cost_usage',function($data){
                    return '<span class="text-xs text-theme-20 whitespace-nowrap mr-4">'.number_format($data->cost_usage).'</span>';
                })
                ->addColumn('cost_amount',function($data){
                    return '<span class="text-xs text-theme-20 whitespace-nowrap mr-4">'.number_format($data->cost_usage).'</span>';
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
                ->rawColumns(['code','name','qty_usage','cost_usage','cost_amount','action'])
                ->make(true);
        }
    }

    public function getDetailIngradiantByID($id)
    {
        return $this->ingradiant->getById($id);
    }

    public function create()
    {
        $title  = 'New Ingradiant';
        $items  = getAllPurchaseItems();
        $result = "";
        $code   = $this->ingradiant->generateCode();
        return view('master.ingradiant.create',compact('title','items','result','code'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->ingradiant->createIngradiant($request);
            DB::commit();
            $notification = array(
                'message'    => 'Ingradiant successfull to saved!',
                'alert-type' => 'success'
            );
            return redirect()->route('masters.ingradiant.create')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message'    => 'Ingradiant failed to saved!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function edit($id)
    {
        $title  = 'Edit Ingradiant';
        $items  = getAllPurchaseItems();
        $result = $this->ingradiant->findIngradiantById($id);
        $code   = $this->ingradiant->generateCode();
        return view('master.ingradiant.create',compact('title','items','result','code'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->ingradiant->updateIngradiant($request, $id);
            DB::commit();
            $notification = array(
                'message'    => 'Ingradiant successfull to updated!',
                'alert-type' => 'success'
            );
            return redirect()->route('masters.ingradiant.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message'    => 'Ingradiant failed to updated!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function destroy($id)
    {

    }
}
