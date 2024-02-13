<?php

namespace App\Http\Controllers\Master;

use App\Core\Interface\Master\CustomerInterface;
use App\Http\Controllers\Controller;
use App\Models\Master\Customer;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    use Response;
    protected CustomerInterface $customer;

    public function __construct(CustomerInterface $customer)
    {
        $this->middleware('auth');
        $this->customer = $customer;
    }

    public function index(Request $request)
    {
        /* $this->authorize('view', Customer::class); */

        if($request->ajax()){
            $results = $this->customer->getAllCustomer();
            return datatables()
                ->of($results)
                ->editColumn('name', function ($row) {
                    $uriEdit = route('masters.customer.edit',['customer' => $row->id ]);
                    return '<a href="'.$uriEdit.'"><span class="text-xs text-success whitespace-nowrap ml-4">'.$row->name.'</span></a>';
                })
                ->editColumn('phone_no', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.($row->phone_no).'</span>';
                })
                ->editColumn('shop_amount', function ($row) {
                    return '<span class="text-xs whitespace-nowrap mr-4">'.number_format($row->shop_amount).'</span>';
                })
                ->addColumn('action', function ($row) {
                    $uriSuspend = "";
                    return '<div class="flex justify-center items-center">
                                <a href="'.$uriSuspend.'" class="flex items-center block p-2 transition duration-300 ease-in-out dark:bg-dark-1 hover:bg-white/5 dark:hover:bg-white/5 rounded-md">
                                    <span class="text-xs text-red-700 text-center">Suspend</span>
                                </a>
                            </div>';
                })
                ->rawColumns(['name','phone_no','shop_amount','status','action'])
                ->make(true);
        }
        return view('master.customer.index');
    }

    public function create()
    {
        /* $this->authorize('create', Customer::class); */
        $title  = 'New Customer';
        $result = "";
        return view('master.customer.create',compact('title','result'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->customer->createCustomer($request);
            DB::commit();
            $notification = array(
                'message' => 'Customer successfull to saved!',
                'alert-type' => 'success'
            );
            return redirect()->route('masters.customer.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message' => 'Customer failed to saved!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function edit($id)
    {
        $this->authorize('update', Customer::class);
        $title  = 'Edit Customer';
        $result = $this->customer->findCustomerById($id);
        return view('master.customer.create',compact('title','result'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->customer->updateCustomer($request, $id);
            DB::commit();
            $notification = array(
                'message' => 'Customer successfull to updated!',
                'alert-type' => 'success'
            );
            return redirect()->route('masters.customer.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message' => 'Customer failed to updated!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function suspend($id)
    {
        $this->authorize('delete', Customer::class);
    }
}
