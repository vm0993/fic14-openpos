<?php

namespace App\Http\Controllers\Master;

use App\Core\Interface\Master\UnitInterface;
use App\Http\Controllers\Controller;
use App\Models\Master\Unit;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    use Response;
    protected UnitInterface $unit;

    public function __construct(UnitInterface $unit)
    {
        $this->middleware('auth');
        $this->unit = $unit;
    }

    public function index(Request $request)
    {
        //$this->authorize('view',Unit::class);
        if($request->ajax()){
            $results = $this->unit->getAllUnit();
            return datatables()
            ->of($results)
            ->editColumn('code', function ($row) {
                return '<a href="javascript:void(0)" data-tw-merge data-tw-toggle="modal" data-tw-target="#docUnit" data-id="'.$row->id.'" data-original-title="Edit" class="editUnit">
                    <span class="text-xs text-success whitespace-nowrap ml-4">'.$row->code.'</span></a>';
            })
            ->editColumn('name', function ($row) {
                return '<span class="text-xs whitespace-nowrap ml-4">'.($row->name).'</span>';
            })
            ->editColumn('status', function ($row) {
                return '<span class="text-xs whitespace-nowrap">'.($row->status).'</span>';
            })
            ->addColumn('action', function ($row) {
                $uriSuspend = "";
                return '<div class="flex justify-center items-center">
                            <a href="'.$uriSuspend.'" class="flex items-center block p-2 transition duration-300 ease-in-out dark:bg-dark-1 hover:bg-white/5 dark:hover:bg-white/5 rounded-md">
                                <span class="text-xs text-red-700 text-center">Suspend</span>
                            </a>
                        </div>';
            })
            ->rawColumns(['name','code','status','action'])
            ->make(true);
        }
        return view('master.unit.index');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->unit->createUnit($request);
            DB::commit();
            if($request->unit_id == ''){
                return response()->json([
                    'success' => true,
                    'message' => 'New Unit succcessfull to saved!',
                ]);
            }else{
                return response()->json([
                    'success' => true,
                    'message' => 'New Unit succcessfull to updated!',
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Unit failed to saved!.',
            ]);
        }
    }

    public function edit($id)
    {
        $result = $this->unit->findUnitById($id);
        return $result;
    }

    public function update(Request $request, $id)
    {

    }

    public function suspend($id)
    {

    }
}
