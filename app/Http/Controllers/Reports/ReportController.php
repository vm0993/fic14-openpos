<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Response\Response;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use Response;

    public function index(Request $request)
    {
        return view('reports.index');
    }
}
