<?php

namespace App\Http\Controllers\Master;

use App\Core\Interface\Master\CategoryInterface;
use App\Http\Controllers\Controller;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    use Response;
    protected CategoryInterface $category;

    public function __construct(CategoryInterface $category)
    {
        $this->middleware('auth');
        $this->category = $category;
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $results = $this->category->getAllCategory();
            return datatables()
                ->of($results)
                ->editColumn('name', function ($row) {
                    return '<a href="javascript:void(0)" data-tw-merge data-tw-toggle="modal" data-tw-target="#docCategory" data-id="'.$row->id.'" data-original-title="Edit" class="editCategory">
                        <span class="text-xs text-success whitespace-nowrap ml-4">'.$row->name.'</span></a>';
                })
                ->editColumn('show_pos', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.($row->show_pos).'</span>';
                })
                ->editColumn('status', function ($row) {
                    return '<span class="text-xs whitespace-nowrap ml-4">'.($row->status).'</span>';
                })
                ->addColumn('action', function ($row) {
                    $uriSuspend = "";
                    return '<div class="flex justify-center items-center">
                                <a href="'.$uriSuspend.'" class="flex items-center block p-2 transition duration-300 ease-in-out dark:bg-dark-1 hover:bg-white/5 dark:hover:bg-white/5 rounded-md">
                                    <span class="text-xs text-red-700 text-center">Suspend</span>
                                </a>
                            </div>';
                })
                ->rawColumns(['name','show_pos','status','action'])
                ->make(true);
        }
        return view('master.category.index');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->category->createCategory($request);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'New Category succcessfull to saved!',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Category failed to saved!.',
            ]);
        }
    }

    public function edit($id)
    {
        $result = $this->category->findCategoryById($id);
        return $result;
    }

    public function update(Request $request, $id)
    {

    }

    public function suspend($id)
    {

    }
}
