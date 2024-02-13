<?php

namespace App\Http\Controllers\Outlets;

use App\Core\Interface\Outlets\PromoInterface;
use App\Http\Controllers\Controller;
use App\Response\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoController extends Controller
{
    use Response;
    protected PromoInterface $promo;

    public function __construct(PromoInterface $promo)
    {
        $this->middleware('auth');
        $this->promo = $promo;
    }

    public function index(Request $request){
        if($request->ajax()){
            $results = $this->promo->getAllPromo($request);
            return datatables()
                ->of($results)
                ->editColumn('code', function ($data) {
                    return '<a href=""><span class="text-xs text-success whitespace-nowrap ml-4">' .$data->code.'</span></a>';
                })
                ->editColumn('promo_type', function ($data) {
                    return '<span class="text-xs whitespace-nowrap ml-4">' .$data->promo_type.'</span>';
                })
                ->addColumn('addDetailUrl',function($row){
                    return route('outlets.outlet.details',['id' => $row['id']]);
                })
                ->editColumn('voucher_qty', function ($data) {
                    return '<span class="text-xs text-left whitespace-nowrap ml-4">'.$data->voucher_qty.'</span>';
                })
                ->addColumn('start_date', function ($data) {
                    return '<span class="text-xs text-left whitespace-nowrap ml-4">'.Carbon::parse($data->start_date)->format('d M Y').'</span>';
                })
                ->editColumn('end_date', function ($data) {
                    return '<span class="text-xs text-left whitespace-nowrap ml-4">'.Carbon::parse($data->end_date)->format('d M Y').'</span>';
                })
                ->addColumn('status', function ($data) {
                    return '<span class="text-xs text-center whitespace-nowrap">'.$data->status.'</span>';
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
                                                    <img src="'. asset("vendor/blade-lucide-icons/eye-off.svg") .'" class="w-4 h-4 mr-2"/>
                                                    <span>Suspend</span>
                                                </a>
                                                <a href="javascript:;" class="flex items-center block p-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-blue rounded-md">
                                                    <img src="'. asset("vendor/blade-lucide-icons/percent.svg") .'" class="w-4 h-4 mr-2"/>
                                                    <span>New Promos</span>
                                                </a>
                                                <a href="javascript:;" class="flex items-center block p-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-blue rounded-md">
                                                    <img src="'. asset("vendor/blade-lucide-icons/person.svg") .'" class="w-4 h-4 mr-2"/>
                                                    <span>New Employee</span>
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
                })
                ->rawColumns(['code','promo_type','voucher_qty','start_date','end_date','status','action'])
                ->make(true);
        }
        return view('outlets.promo.index');
    }

    public function getDetails(Request $request, $id)
    {
        if($request->ajax()){
            $results = $this->promo->getDetailPromoById($id);
            return datatables()
                ->of($results)
                ->editColumn('voucher_promo', function ($data) {
                    return '<a href=""><span class="text-xs text-success whitespace-nowrap">' .$data->voucher_promo.'</span></a>';
                })
                ->editColumn('status', function ($data) {
                    return '<span class="text-xs whitespace-nowrap">' .$data->status.'</span>';
                })
                ->addColumn('apply_date', function ($data) {
                    if($data->apply_date == null){
                        return '<span class="text-xs text-left whitespace-nowrap ml-4"></span>';
                    }else{
                        return '<span class="text-xs text-left whitespace-nowrap ml-4">'.Carbon::parse($data->apply_date)->format('d F Y').'</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    return '<div class="flex justify-center items-center">
                                <div class="intro-y flex flex-wrap sm:flex-nowrap items-center">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle btn btn-sm px-2 box text-gray-700 dark:text-gray-300" data-tw-toggle="dropdown" aria-expanded="false">
                                            <img src="'. asset("vendor/blade-lucide-icons/more-vertical.svg") .'" class="w-4 h-4"/>
                                        </button>
                                    </div>
                                </div>
                            </div>';
                })
                ->rawColumns(['voucher_promo','apply_date','status','action'])
                ->make(true);
        }
    }

    public function create()
    {
        $title  = 'New Promo';
        $result = "";
        return view('outlets.promo.create',compact('title','result'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->promo->createPromo($request);
            DB::commit();
            $notification = array(
                'message' => 'Promo successfull to saved!',
                'alert-type' => 'success'
            );
            return redirect()->route('outlets.promo.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message' => 'Promo failed to saved!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function edit($id)
    {
        $title  = 'Edit Promo';
        $result = $this->promo->findPromoById($id);
        return view('outlets.promo.create',compact('title','result'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->promo->updatePromo($request, $id);
            DB::commit();
            $notification = array(
                'message' => 'Promo successfull to updated!',
                'alert-type' => 'success'
            );
            return redirect()->route('outlets.promo.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message' => 'Promo failed to updated!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function suspend($id)
    {

    }
}
