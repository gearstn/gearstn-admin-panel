<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;

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
    //Login & register Frontend
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::get('/auth/login',[AuthController::class, 'login'])->name('frontend_login');
    Route::get('/auth/get-token',[AuthController::class, 'get_token'])->name('get_token');

    //Verification Routes
    Route::post('/email/verify', [AuthController::class, 'verify']);

    // FORGET PASSWORD
	Route::post('/password/email', [AuthController::class, 'sendPasswordResetLinkEmail'])->middleware('throttle:5,1')->name('password.email');
	Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.reset');

    Route::get('/change-lang/{lang}', function ($lang) {
        App::setLocale($lang);
        return Config::get('app.locale');
    });

    //Auth routes
    Route::middleware('auth:sanctum')->group( function () {

        //Logout User
        Route::post('/auth/logout',[AuthController::class, 'logout']);

        //Verification Routes
        Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware(['signed']);
        Route::post('/email/resend',[VerificationController::class, 'resend'])->name('verification.resend');
        Route::get('/dashboard', [DashboardController::class,'index']);
    });
});
