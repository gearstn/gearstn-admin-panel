<?php

use Illuminate\Support\Facades\Route;
use Modules\Machine\Http\Controllers\MachineController;

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
Route::group(['middleware' => 'cors'], function () {

    //Auth routes
    Route::middleware('auth:sanctum')->group( function () {
        //Store Update Destroy routes for Machines and Models
        Route::resource('machines', 'MachineController' ,['as' => 'frontend'])->only('store','update','destroy');
        Route::get('/user-machines', [MachineController::class, 'user_machines']);
    });

    //Search for all Entities
    Route::resource('machines', 'MachineController' ,['as' => 'frontend'])->except('create', 'edit');
    Route::get('/machines-search', [MachineController::class, 'search_filter']);
    Route::get('/machines-filter-data', [MachineController::class, 'getMinMaxOfField']);
    Route::get('/related-machines', [MachineController::class, 'getRelatedMachines']);
    Route::get('/machine-price', [MachineController::class, 'get_machine_price']);
    Route::get('/latest-machines', [MachineController::class, 'latest_machines'] ,['as' => 'frontend']);
    Route::get('/machine-view', [MachineController::class, 'add_machine_view']);


});
