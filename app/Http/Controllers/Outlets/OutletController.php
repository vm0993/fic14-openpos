<?php

namespace App\Http\Controllers\Outlets;

use App\Core\Interface\Outlets\OutletEmployeeInterface;
use App\Http\Controllers\Controller;
use App\Models\Master\Outlet;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    use Response;
    protected OutletEmployeeInterface $outlet;

    public function __construct(OutletEmployeeInterface $outlet)
    {
        $this->middleware('auth');
        $this->outlet = $outlet;
    }

    public function index(Request $request)
    {
        $this->authorize('view',Outlet::class);
        if($request->ajax()){
            $results = $this->outlet->getAllOutlet($request);
            return datatables()
                ->of($results)
                ->editColumn('code', function ($data) {
                    return '<a href="javascript:void(0)" data-tw-merge data-tw-toggle="modal" data-tw-target="#docOutlet" data-id="'.$data->id.'" data-original-title="Edit" class="editOutlet">
                        <span class="text-xs text-success whitespace-nowrap ml-4">' .$data->code.'</span>
                    </a>';
                })
                ->editColumn('name', function ($data) {
                    return '<span class="text-xs whitespace-nowrap ml-4">' .$data->name.'</span>';
                })
                ->addColumn('addDetailUrl',function($data){
                    return route('outlets.outlet.detail-outlets',['id' => $data['id']]);
                })
                ->editColumn('address', function ($data) {
                    return '<span class="text-xs text-left whitespace-nowrap ml-4">'.$data->address.'</span>';
                })
                ->addColumn('phone_no', function ($data) {
                    return '<span class="text-xs text-left whitespace-nowrap ml-4">'.$data->phone_no.'</span>';
                })
                ->editColumn('email', function ($data) {
                    return '<span class="text-xs text-left whitespace-nowrap ml-4">'.$data->email.'</span>';
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
                                                    <img src="'. asset("vendor/blade-lucide-icons/person-standing.svg") .'" class="w-4 h-4 mr-2"/>
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
                ->rawColumns(['code','name','address','phone_no','email','status','action'])
                ->make(true);
        }
        $title = 'Outlet Lists';
        return view('outlets.outlet.index',compact('title'));
    }

    public function getDetailOutlet(Request $request, $id)
    {
        if($request->ajax()){
            $results = $this->outlet->getOutletEmployeeDetails($id);
            return datatables()
            ->of($results)
            ->editColumn('name', function ($row) {
                $uriEdit = route('outlets.employee.edit',['employee' => $row->id ]);
                return '<a href="'.$uriEdit.'"><span class="text-xs text-success whitespace-nowrap">'.$row->name.'</span></a>';
            })
            ->editColumn('code', function ($row) {
                return '<span class="text-xs whitespace-nowrap">'.($row->code).'</span>';
            })
            ->editColumn('address', function ($row) {
                return '<span class="text-xs whitespace-nowrap">'.$row->address.'</span>';
            })
            ->editColumn('email', function ($row) {
                return '<span class="text-xs whitespace-nowrap">'.$row->email.'</span>';
            })
            ->editColumn('phone_no', function ($row) {
                return '<span class="text-xs whitespace-nowrap">'.$row->phone_no.'</span>';
            })
            ->editColumn('status', function ($row) {
                return '<span class="text-xs whitespace-nowrap">'.$row->status.'</span>';
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
            ->rawColumns(['code','name','address','phone_no','email','status','action'])
            ->make(true);
        }
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->outlet->createOutlet($request);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Outlet succcessfull to saved/updated!',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(), //'Outlet failed to saved!.',
            ]);
        }
    }

    public function edit($id)
    {
        $result = $this->outlet->findOutletById($id);
        return $result;
    }

    public function show($id)
    {

    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->outlet->updateOutlet($request, $id);
            DB::commit();
            $notification = array(
                'message'    => 'Outlet successfull to updates!',
                'alert-type' => 'success'
            );
            //return redirect()->route('master.perguruan.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message'    => $th->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function destroy($id)
    {

    }

    public function suspend($id)
    {
        DB::beginTransaction();
        try {
            $this->outlet->suspendOutletById($id);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
