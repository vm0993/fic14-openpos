<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Inventory\ItemIncomingController;
use App\Http\Controllers\Inventory\ItemOpnameController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\CustomerController;
use App\Http\Controllers\Master\IngradiantController;
use App\Http\Controllers\Master\ItemController;
use App\Http\Controllers\Master\UnitController;
use App\Http\Controllers\Outlets\EmployeeController;
use App\Http\Controllers\Outlets\OutletController;
use App\Http\Controllers\Outlets\PromoController;
use App\Http\Controllers\Reports\ReportController;
use App\Http\Controllers\Settings\CompanyController;
use App\Http\Controllers\Settings\PermissionGroupController;
use App\Http\Controllers\Settings\UserController;
use App\Http\Controllers\SetupController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['verify' => true]);
Route::group(['middleware' => ['auth', 'verified']], function () {
    //Route Dashboard Group
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/',[DashboardController::class,'getIndex'])->name('dashboard');
    });

    Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
        Route::get('/',
            [ReportController::class,'index'])->name('index');
    });

    Route::group(['prefix' => 'outlets', 'as' => 'outlets.'], function () {
        Route::resources([
            'outlet'   => OutletController::class,
            'employee' => EmployeeController::class,
            'promo'    => PromoController::class,
        ]);
        Route::get('outlet/{id}/get-employee',
            [OutletController::class,'getDetailOutlet'])->name('outlet.detail-outlets');
        Route::get('promo/{id}/details',
            [PromoController::class,'getDetails'])->name('outlet.details');
    });

    Route::group(['prefix' => 'masters', 'as' => 'masters.'], function () {
        Route::resources([
            'category'    => CategoryController::class,
            'unit'        => UnitController::class,
            //'tax'         => \App\Http\Controllers\Master\TaxController::class,
            'item'        => ItemController::class,
            'ingradiant'  => IngradiantController::class,
            'customer'    => CustomerController::class,
        ]);
        Route::post('item/get-number',
            [ItemController::class,'generateItemNo'])->name('item.get-number');
        Route::get('ingradiant/{id}/details',
            [IngradiantController::class,'getDetailIngradiant'])->name('ingradiant.details');
        Route::get('ingradiant/{id}/detail-ingradiant',
            [IngradiantController::class,'getDetailIngradiantByID'])->name('ingradiant.detail-ingradiant');

    });

    Route::group(['prefix' => 'inventorys', 'as' => 'inventorys.'], function () {
        Route::resources([
            'item-incoming'    => ItemIncomingController::class,
            'item-opname'      => ItemOpnameController::class,
            'item-adjustment'  => \App\Http\Controllers\Master\TaxController::class,
            'stock-monitoring' => \App\Http\Controllers\Master\ItemController::class,
        ]);
        //Item-Incoming
        Route::post('item-incoming/get-incoming-number',
            [ItemIncomingController::class,'setIncomingNumber'])->name('item-incoming.get-incoming-number');
        Route::get('item-incoming/{id}/detail',
            [ItemIncomingController::class,'getDetailByIncomingID'])->name('item-incoming.detail');
        Route::get('item-incoming/{id}/get-detail',
            [ItemIncomingController::class,'getDetailIncoming'])->name('item-incoming.get-detail');
        //Item Opname
        Route::post('item-opname/get-opname-number',
            [ItemOpnameController::class,'setOpnameNumber'])->name('item-opname.get-opname-number');
        Route::get('item-opname/{id}/detail',
            [ItemOpnameController::class,'getDetailByOpnameID'])->name('item-opname.detail');
        Route::get('item-opname/{id}/get-detail',
            [ItemOpnameController::class,'getDetailOpname'])->name('item-opname.get-detail');
    });

    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::resources([
            'company'           => CompanyController::class,
            'group-permissions' => PermissionGroupController::class,
            'user'              => UserController::class,
        ]);
        Route::post('company/{company_id}/item-default',
            [CompanyController::class,'storeItemDefault'])->name('company.item-default');
        Route::post('company/{company_id}/item-default/{id}',
            [CompanyController::class,'updateItemDefault'])->name('company.update-item-default');
        Route::get('group-permissions/{id}/details',
            [PermissionGroupController::class,'getDetailPermission'])->name('group-permissions.details');
        Route::get('group-permissions/{id}/new-user',
            [PermissionGroupController::class,'setNewUser'])->name('group-permissions.new-user');
        Route::post('group-permissions/{id}/new-user',
            [PermissionGroupController::class,'storeNewUser'])->name('group-permissions.post-new-user');
    });

});

Route::group(['prefix' => 'setup', 'middleware' => 'web'], function () {
    Route::get(
        'user',
        [SetupController::class, 'getSetupUser']
    )->name('setup.user');

    Route::post(
        'user',
        [SetupController::class, 'postSaveFirstUser']
    )->name('setup.user.save');

    Route::get(
        'migrate',
        [SetupController::class, 'getSetupMigrate']
    )->name('setup.migrate');

    Route::get(
        'done',
        [SetupController::class, 'getSetupDone']
    )->name('setup.done');

    Route::get(
        'mailtest',
        [SetupController::class, 'ajaxTestEmail']
    )->name('setup.mailtest');

    Route::get(
        '/',
        [SetupController::class, 'getSetupIndex']
    )->name('setup');
});

Route::group(['middleware' => 'web'], function () {

    Route::get(
        'login',
        [LoginController::class, 'showLoginForm']
    )->name("login");

    Route::post(
        'login',
        [LoginController::class, 'login']
    );

});
