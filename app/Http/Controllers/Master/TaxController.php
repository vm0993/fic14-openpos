<?php

namespace App\Http\Controllers\Master;

use App\Core\Interface\Master\TaxInterface;
use App\Http\Controllers\Controller;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaxController extends Controller
{
    use Response;
    protected TaxInterface $tax;

    public function __construct(TaxInterface $tax)
    {
        $this->middleware('auth');
        $this->tax = $tax;
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $results = $this->tax->getAllTaxes();
            return datatables()
            ->of($results)
            ->editColumn('code', function ($row) {
                $uriEdit = route('masters.tax.edit',['tax' => $row['id']]);
                return '<a href="'.$uriEdit.'" >
                    <span class="text-xs text-success whitespace-nowrap ml-4">'.$row->code.'</span></a>';
            })
            ->editColumn('description', function ($row) {
                return '<span class="text-xs whitespace-nowrap ml-4">'.($row->description).'</span>';
            })
            ->editColumn('status', function ($row) {
                return '<span class="text-xs whitespace-nowrap">'.($row->status).'</span>';
            })
            ->editColumn('tax_rate', function ($row) {
                return '<span class="text-xs whitespace-nowrap ml-4">'.($row->tax_rate).'</span>';
            })
            ->addColumn('purchase', function ($row) {
                return '<span class="text-xs whitespace-nowrap ml-4">'.($row->purchase).'</span>';
            })
            ->addColumn('sales', function ($row) {
                return '<span class="text-xs whitespace-nowrap ml-4">'.($row->sales).'</span>';
            })
            ->addColumn('action', function ($row) {
                $uriSuspend = "";
                return '<div class="flex justify-center items-center">
                            <a href="'.$uriSuspend.'" class="flex items-center block p-2 transition duration-300 ease-in-out dark:bg-dark-1 hover:bg-white/5 dark:hover:bg-white/5 rounded-md">
                                <span class="text-xs text-red-700 text-center">Suspend</span>
                            </a>
                        </div>';
            })
            ->rawColumns(['description','code','status','sales','tax_rate','purchase','action'])
            ->make(true);
        }
        return view('master.tax.index');
    }

    public function create()
    {
        $title  = 'New Tax Rate';
        $result = "";
        return view('master.tax.create',compact('title','result'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->tax->createTax($request);
            DB::commit();
            $notification = array(
                'message'    => 'Tax successfull to saved!',
                'alert-type' => 'success'
            );
            return redirect()->route('masters.tax.index')->with($notification);
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
        $title  = 'Edit Tax Rate';
        $result = $this->tax->findTaxById($id);
        return view('master.tax.create',compact('title','result'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->tax->updateTax($request, $id);
            DB::commit();
            $notification = array(
                'message'    => 'Tax successfull to updated!',
                'alert-type' => 'success'
            );
            return redirect()->route('masters.tax.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'message'    => $th->getMessage(),   //'Item failed to saved!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function suspend($id)
    {

    }
}
