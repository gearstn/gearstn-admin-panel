<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Subscription\Http\Controllers\SubscriptionController;

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
        //Auth routes
        Route::resource('subscriptions','SubscriptionController' ,['as' => 'frontend'])->only('index','show');
        Route::get('single-machine-listing', [SubscriptionController::class , 'get_single_listing' ] ,['as' => 'frontend']);

        Route::middleware('auth:sanctum')->group( function () {
            Route::post('subscriptions/subscribe', [SubscriptionController::class , 'subscribe' ] ,['as' => 'frontend']);
            Route::post('subscriptions/unsubscribe', [SubscriptionController::class , 'unsubscribe' ] ,['as' => 'frontend']);
            Route::get('user-subscriptions-by-type', [SubscriptionController::class , 'user_subscriptions_by_type' ] ,['as' => 'frontend']);
            Route::get('user-all-subscriptions', [SubscriptionController::class , 'user_all_subscriptions' ] ,['as' => 'frontend']);
            Route::post('extra-plan-subscribe', [SubscriptionController::class , 'extra_plan_subscribe' ] ,['as' => 'frontend']);
            Route::get('user-extra-subscriptions', [SubscriptionController::class , 'user_extra_subscriptions' ] ,['as' => 'frontend']);
        });
});
