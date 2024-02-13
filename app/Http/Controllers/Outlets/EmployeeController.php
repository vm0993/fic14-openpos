<?php

namespace App\Http\Controllers\Outlets;

use App\Core\Interface\Outlets\EmployeeInterface;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    use Response;
    protected EmployeeInterface $employee;

    public function __construct(EmployeeInterface $employee)
    {
        $this->middleware('auth');
        $this->employee = $employee;
    }

    public function index(Request $request){
        if($request->ajax()){
            $results = $this->employee->getAllEmployee($request);
            return datatables()
                ->of($results)
                ->editColumn('name', function ($row) {
                    $uriEdit = route('outlets.employee.edit',['employee' => $row->id ]);
                    return '<a href="'.$uriEdit.'"><span class="text-xs text-success whitespace-nowrap ml-4">'.$row->name.'</span></a>';
                })
                ->addColumn('addDetailUrl',function($row){
                    return "";
                })
                ->addColumn('outlet_name', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.($row->outlet->name).'</span>';
                })
                ->editColumn('code', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.($row->code).'</span>';
                })
                ->editColumn('address', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.$row->address.'</span>';
                })
                ->editColumn('email', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.$row->email.'</span>';
                })
                ->editColumn('phone_no', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.$row->phone_no.'</span>';
                })
                ->editColumn('status', function ($row) {
                    return '<span class="text-xs whitespace-nowrap">'.$row->status.'</span>';
                })
                ->addColumn('action', function ($row) {
                    $uriSuspend = "";
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
                ->rawColumns(['name','code','outlet_name','address','email','phone_no','status','action'])
                ->make(true);
        }
        return view('outlets.employees.index');
    }

    public function create(Request $request)
    {
        $permissions     = config('permission');
        $userPermissions = Helper::selectedPermissionsArray($permissions, []);
        $permissions     = $this->filterDisplayable($permissions);
        $varArray = [];
        foreach ($userPermissions as $key => $permissionArray) {
            $varArray[]  = [
               $key => $key == 'admin' ? 0 : 1,
            ];
        }
        $title  = 'New Employee';
        $result = "";
        return view('outlets.employees.create',compact('title','result'));
    }

    private function filterDisplayable($permissions)
    {
        $output = null;
        foreach ($permissions as $key => $permission) {
            $output[$key] = array_filter($permission, function ($p) {
                return $p['display'] === true;
            });
        }

        return $output;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->employee->createEmployee($request);
            DB::commit();
            $notification = array(
                'message' => 'Employee successfull to saved!',
                'alert-type' => 'success'
            );
            return redirect()->route('outlets.employee.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message' => 'Employee failed to saved!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function edit($id)
    {
        $title  = 'Edit Employee';
        $result = $this->employee->findEmployeeById($id);
        return view('outlets.employees.create',compact('title','result'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->employee->updateEmployee($request, $id);
            DB::commit();
            $notification = array(
                'message' => 'Employee successfull to updated!',
                'alert-type' => 'success'
            );
            return redirect()->route('outlets.employee.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message' => 'Employee failed to updated!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function suspend($id)
    {

    }
}
