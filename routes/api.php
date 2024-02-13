<?php

use App\Http\Controllers\Api\v1\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::post('/login',  [LoginController::class, 'login']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        //Profile Update
        Route::get('get-user',[LoginController::class, 'getActiveUser']);

        //Logout
        Route::post('logout',  [LoginController::class, 'logoutUser']);
    });
});
