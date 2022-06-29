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


Route::group(['middleware' => 'cors'], function () {
    //Auth routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('plans')->group(function () {
            Route::get('/single-machine-listing', [SubscriptionController::class, 'get_single_listing']);
            Route::get('/user-subscriptions-by-type', [SubscriptionController::class, 'user_subscriptions_by_type']);
            Route::get('/user-all-subscriptions', [SubscriptionController::class, 'user_all_subscriptions']);
            Route::post('/extra-plan-subscribe', [SubscriptionController::class, 'extra_plan_subscribe']);
            Route::get('/user-extra-subscriptions', [SubscriptionController::class, 'user_extra_subscriptions']);
            Route::post('/{plan}', [SubscriptionController::class, 'update']);
            Route::get('/all-plan-filtered', [SubscriptionController::class, 'get_plans_filtered']);
        });
        Route::prefix('subscriptions')->group(function () {
            Route::get('/', [SubscriptionController::class, 'all_users_subscriptions']);
            Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);
            Route::post('/unsubscribe', [SubscriptionController::class, 'unsubscribe']);
            Route::get('/{id}', [SubscriptionController::class, 'get_subscription']);
            Route::post('/{subscription}', [SubscriptionController::class, 'update_subscription']);
        });
        Route::resource('plans', 'SubscriptionController')->except('update');
    });
});
