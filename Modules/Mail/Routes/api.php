<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Mail\Http\Controllers\MailController;
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
        //Mails Routes
        Route::get('/contact-seller', [MailController::class, 'contact_seller'])->name('contact-seller');
        Route::get('/store-machine', [MailController::class, 'store_machine'])->name('store-machine');
        Route::get('/store-spare-part', [MailController::class, 'store_spare_part'])->name('store-spare-part');
        Route::get('/open-conversation-with-seller', [MailController::class, 'open_conversation_with_seller'])->name('open-conversation-with-seller');
    });
});
