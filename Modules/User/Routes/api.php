<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\SavedListController;
use Modules\User\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Routes for frontend
Route::group(['prefix' => '/','middleware' => 'cors'], function () {
    //Auth routes
    Route::middleware('auth:sanctum')->group( function () {
        //User profile routes
        Route::post('/users/change-password',[UserController::class, 'change_password']);
        Route::get('/users/profile',[UserController::class, 'getNormalUser']);
        Route::get('/users/full-profile',[UserController::class, 'getFullUser']);
        Route::post('/users',[UserController::class, 'update'])->name('users.update');
        Route::get('/users/phone',[UserController::class, 'get_phone']);
        Route::post('/users/request_account_manager',[UserController::class, 'request_account_manager'])->name('users.request_account_manager');
        Route::get('/users/get-machines-distributors',[UserController::class, 'get_machines_distributors'])->name('users.get_machines_distributors');
        Route::get('/users/get-services-providers',[UserController::class, 'get_services_providers'])->name('users.get_services_providers');
        Route::post('users/{user}', [UserController::class, 'update']);

        Route::get('/list', [SavedListController::class,'getList'])->name('list');
        Route::post('/list/add', [SavedListController::class,'addToList'])->name('list.add');
        Route::post('/list/remove', [SavedListController::class,'removeItem'])->name('list.remove');
        Route::get('/list/clear', [SavedListController::class,'clearList'])->name('list.clear');
        Route::resource('users','UserController')->except('update');
        Route::resource('roles','RoleController');
    });
});
