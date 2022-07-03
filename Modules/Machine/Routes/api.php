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
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('/machines')->group(function () {
            Route::get('/user-machines', [MachineController::class, 'user_machines']);
            Route::get('/machines-search', [MachineController::class, 'search_filter']);
            Route::get('/machines-filter-data', [MachineController::class, 'getMinMaxOfField']);
            Route::get('/related-machines', [MachineController::class, 'getRelatedMachines']);
            Route::get('/machine-price', [MachineController::class, 'get_machine_price']);
            Route::get('/latest-machines', [MachineController::class, 'latest_machines'], ['as' => 'frontend']);
            Route::get('/machine-view', [MachineController::class, 'add_machine_view']);
            Route::delete('/machine-delete-image', [MachineController::class, 'delete_machine_image']);
            Route::post('/{machine}', [MachineController::class, 'update']);
            Route::post('/approve',  [ MachinesController::class,'approveMachine' ])->name('machines.approve');
            Route::post('/feature',  [ MachinesController::class,'featureMachine' ])->name('machines.feature');
            Route::post('/verify',  [ MachinesController::class,'verifyMachine' ])->name('machines.verify');
        });
        Route::resource('machines', 'MachineController', ['as' => 'frontend'])->except('update');
    });
});
