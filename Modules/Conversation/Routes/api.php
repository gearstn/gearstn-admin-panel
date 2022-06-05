<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Conversation\Http\Controllers\ConversationController;

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
        Route::resource('conversations', 'ConversationController' ,['as' => 'frontend'])->only('store','destroy');
        Route::get('/user-conversation', [ConversationController::class, 'get_user_conversations']);
        Route::get('/check-for-conversation', [ConversationController::class, 'check_for_conversation']);
    });
});
