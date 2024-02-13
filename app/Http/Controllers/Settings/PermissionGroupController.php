<?php

namespace App\Http\Controllers\Settings;

use App\Core\Interface\Settings\PermissionGroupInterface;
use App\Core\Interface\Settings\UserInterface;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\PermissionGroup;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionGroupController extends Controller
{
    use Response;
    protected PermissionGroupInterface $permission;
    protected UserInterface $user;

    public function __construct(
        PermissionGroupInterface $permission,
        UserInterface $user)
    {
        $this->middleware('auth');
        $this->permission = $permission;
        $this->user = $user;
    }

    public function index(Request $request)
    {
        //$this->authorize('view',PermissionGroup::class);
        $title = 'Group Permission Lists';
        if($request->ajax()){
            $results = $this->permission->getPermissionGroup();
            return datatables()
            ->of($results)
            ->editColumn('name', function ($data) {
                return '<a href="javascript:void(0)">
                    <span class="text-xs text-success whitespace-nowrap ml-4">' .$data->name.'</span>
                </a>';
            })
            ->addColumn('addDetailUrl',function($data){
                return route('settings.group-permissions.details',['id' => $data['id']]);
            })
            ->addColumn('action', function ($data) {
                $newUser = route('settings.group-permissions.new-user',['id' => $data['id']]);
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
                                            <a href="'.$newUser.'" class="flex items-center block p-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-blue rounded-md">
                                                <img src="'. asset("vendor/blade-lucide-icons/person-standing.svg") .'" class="w-4 h-4 mr-2"/>
                                                <span>New User</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            })
            ->rawColumns(['name','action'])
            ->make(true);
        }
        return view('settings.permissions.index',compact('title'));
    }

    public function getDetailPermission(Request $request, $id)
    {
        if($request->ajax()){
            $results = $this->permission->getPermissionDetailById($id);
            return datatables()
            ->of($results)
            ->editColumn('name', function ($data) {
                return '<a href="javascript:void(0)">
                    <span class="text-xs text-success whitespace-nowrap">' .$data->name.'</span>
                </a>';
            })
            ->editColumn('email', function ($data) {
                return '<span class="text-xs text-success whitespace-nowrap">' .$data->email.'</span>';
            })
            ->editColumn('user_type', function ($data) {
                return '<span class="text-xs text-success whitespace-nowrap">' .$data->user_type.'</span>';
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
            ->rawColumns(['name','email','user_type','action'])
            ->make(true);
        }
    }

    public function setNewUser(Request $request, $id)
    {
        $title  = "Create New User";
        $group  = $this->permission->findPermissionGroupById($id);
        $result = "";
        return view('settings.permissions.create-user',compact('id','group','title','result'));
    }

    public function storeNewUser($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $this->user->createUserByPermission($id, $request);
            DB::commit();
            $notification = array(
                'message' => 'User successfull to saved!',
                'alert-type' => 'success'
            );
            return redirect()->route('settings.group-permissions.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message' => 'User failed to saved!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function create()
    {
        $title           = 'New Permission';
        $result          = "";
        $permissions     = config('permission');
        $userPermissions = Helper::selectedPermissionsArray($permissions, []);
        $permissions     = $this->filterDisplayable($permissions);
        $varArray        = [];
        //dd($permissions);
        foreach ($userPermissions as $key => $permissionArray) {
            $varArray[]  = [
               $key => $key == 'admin' || $key == 'cashier' || $key == 'waiter' ? 0 : 1,
            ];
        }

        /* foreach ($permissions as $key => $permissionArray) {
            if(count($permissionArray) == 1){
                $localPermission = $permissionArray[0];
                $varArray[]  = [
                    $localPermission['permission'] => $localPermission['permission'] == 'admin' || $localPermission['permission'] == 'cashier' || $localPermission['permission'] == 'waiter' ? 0 : 1,
                ];
            }else{
                $localPermission = $permissionArray[0];
                $varArray[]  = [
                    $localPermission['permission'] => $localPermission['permission'] == 'admin' || $localPermission['permission'] == 'cashier' || $localPermission['permission'] == 'waiter' ? 0 : 1,
                ];
            }
        } */

        dd(json_encode($varArray));
        return view('settings.permissions.create',compact('title','result'));
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
}
