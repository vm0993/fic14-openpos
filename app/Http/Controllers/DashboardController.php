<?php

namespace App\Http\Controllers;

use App\Core\Interface\Settings\PermissionGroupInterface;
use App\Models\PermissionGroup;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use Response;
    protected PermissionGroupInterface $permission;

    public function __construct(
        PermissionGroupInterface $permission
    )
    {
        $this->middleware('auth');
        $this->permission = $permission;
    }

    public function getIndex()
    {
        $title = env('APP_NAME').' Dashboard';
        if (Auth::user()->hasAccess('superuser')) {
            return view('home',compact('title'));
        } else {
            return view('home',compact('title'));
        }
    }

    protected function checkPermissionSection($section)
    {
        $groups = PermissionGroup::find(auth()->user()->permission_group_id);
        $is_user_section_permissions_set = ($groups['permission'] != '') && array_key_exists($section, $groups['permission']);
        //If the user is explicitly granted, return true
        if ($is_user_section_permissions_set && ($groups['permission'][$section] == '1')) {
            return true;
        }
        // If the user is explicitly denied, return false
        if ($is_user_section_permissions_set && ($groups['permission'][$section] == '-1')) {
            return false;
        }

        return false;
    }
}
