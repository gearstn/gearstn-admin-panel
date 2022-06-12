<?php

use Illuminate\Support\Facades\Route;
use Modules\Transaction\Http\Controllers\TransactionController;

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


Route::group(['prefix' => '/','middleware' => 'cors'], function () {
    Route::middleware('auth:sanctum')->group( function () {
        Route::resource('transactions','TransactionController');
        Route::get('user-transactions', [TransactionController::class , 'user_transactions' ] ,['as' => 'frontend']);
        Route::post('extra-plan', [TransactionController::class , 'extra_plan_store' ] ,['as' => 'frontend']);
    });
});
