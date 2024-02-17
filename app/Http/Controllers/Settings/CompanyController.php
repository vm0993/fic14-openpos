<?php

namespace App\Http\Controllers\Settings;

use App\Core\Interface\Settings\CompanyInterface;
use App\Core\Interface\Settings\ItemDefaultInterface;
use App\Http\Controllers\Controller;
use App\Models\Sistem\Company;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    use Response;
    protected CompanyInterface $company;

    public function __construct(
        CompanyInterface $company,
    )
    {
        $this->middleware('auth');
        $this->company     = $company;
    }

    public function index()
    {
        /* $this->authorize('view',Company::class); */
        $result  = $this->company->getCompany();
        if(!empty($result)){
            $title = 'Edit Company';
        }else{
            $title = 'Company Profile';
        }
        return view('settings.company.index',compact('result','title'));
    }

    public function store(Request $request)
    {
        /* $this->authorize('create',Company::class); */
        DB::beginTransaction();
        try {
            $this->company->createCompany($request);
            DB::commit();
            $notification = array(
                'message' => 'Company successfull to saved!',
                'alert-type' => 'success'
            );
            return redirect()->route('settings.company.index')->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => 'Company failed to saved!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function update(Request $request, $id)
    {
        /* $this->authorize('edit',Company::class); */
        DB::beginTransaction();
        try {
            $this->company->updateCompany($request, $id);
            DB::commit();
            $notification = array(
                'message' => 'Company successfull to updated!',
                'alert-type' => 'success'
            );
            return redirect()->route('settings.company.index')->with($notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => 'Company failed to updated!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

}
