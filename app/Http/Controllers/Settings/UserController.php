<?php

namespace App\Http\Controllers\Settings;

use App\Core\Interface\Settings\UserInterface;
use App\Http\Controllers\Controller;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use Response;
    protected UserInterface $user;

    public function __construct(UserInterface $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $results = $this->user->getUsers();
            return datatables()
            ->of($results)
            ->editColumn('name', function ($data) {
                $uriEdit = route('settings.user.edit',['user'=> $data['id']]);
                return '<a href="'.$uriEdit.'">
                    <span class="text-xs text-success whitespace-nowrap ml-4">' .$data->name.'</span>
                </a>';
            })
            ->editColumn('email', function ($row) {
                return '<span class="text-xs whitespace-nowrap ml-4">'.$row->email.'</span>';
            })
            ->editColumn('permission_name', function ($row) {
                return '<span class="text-xs whitespace-nowrap ml-4">'.$row->permission_name.'</span>';
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
                                                <span>New User</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            })
            ->rawColumns(['name','email','permission_name','action'])
            ->make(true);
        }
        return view('settings.users.index');
    }

    public function create()
    {
        $title  = 'Create New User';
        $result = "";
        return view('settings.users.create',compact('title','result'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->user->createUser($request);
            DB::commit();
            $notification = array(
                'message'    => 'User successfull to saved!',
                'alert-type' => 'success'
            );
            return redirect()->route('settings.user.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message'    => 'User failed to saved!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function edit($id)
    {
        $title  = 'Edit User';
        $result = $this->user->findUserById($id);
        return view('settings.users.create',compact('title','result'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->user->updateUser($request, $id);
            DB::commit();
            $notification = array(
                'message'    => 'User successfull to updated!',
                'alert-type' => 'success'
            );
            return redirect()->route('settings.user.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message'    => 'User failed to updated!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
