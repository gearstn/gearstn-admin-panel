<?php

use App\Http\Controllers\Admin\AccountManagerController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AuctionsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CitiesController;
use App\Http\Controllers\Admin\ConversationsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\MachineModelsController;
use App\Http\Controllers\Admin\MachinesController;
use App\Http\Controllers\Admin\ManufacturesController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SubCategoriesController;
use App\Http\Controllers\Admin\SubscriptionsController;
use App\Http\Controllers\Admin\UsersControllers;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\UploadsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::group(['before' => 'force.ssl'], function () {

//Admin routes
Route::prefix('admin')->group(function () {
    Auth::routes(['register' => false]);
});
Route::get('/', function () {
    return view('welcome');
});
    // Route::post('/auth/register', [AuthController::class, 'register']);
    // Route::get('/auth/login',[AuthController::class, 'login_admin'])->name('login_admin');

    //Auth for admin routes
    Route::group(['prefix' => 'admin','middleware' => ['auth','cors']], function () {

        Route::get('/',[DashboardController::class, 'index'])->name("dashboard");
        Route::resource('/categories',CategoriesController::class);
        Route::resource('/sub-categories',SubCategoriesController::class);
        Route::resource('/manufactures',ManufacturesController::class);
        Route::resource('/machine-models', MachineModelsController::class);
        Route::resource('/machines', MachinesController::class)->except('show');
        Route::get('/fetchSubCategories', [ MachinesController::class,'fetchSubCategories' ])->name('fetchSubCategories');
        Route::get('/fetchMachineModels', [ MachinesController::class,'fetchMachineModels' ])->name('fetchMachineModels');
        Route::post('/machines/approve',  [ MachinesController::class,'approveMachine' ])->name('machines.approve');
        Route::post('/machines/feature',  [ MachinesController::class,'featureMachine' ])->name('machines.feature');
        Route::post('/machines/verify',  [ MachinesController::class,'verifyMachine' ])->name('machines.verify');

        Route::resource('/news', NewsController::class);
        Route::resource('/auctions', AuctionsController::class);
        Route::resource('/cities', CitiesController::class);
        Route::resource('/users', UsersControllers::class);
        Route::resource('/employees', EmployeesController::class)->except('show');
        Route::post('/uploads', [UploadsController::class,'store'] )->name('uploads.store');
        Route::post('/local_uploads', [UploadsController::class,'local_upload'] )->name('uploads.local_storage');
        Route::post('/uploads-destroy', [UploadsController::class , 'destroy'])->name('uploads.destroy');


        Route::resource('/settings', SettingsController::class)->except(['update', 'destroy', 'edit', 'store', 'create']);
        Route::post('/settings', [SettingsController::class,'update'])->name("settings.update");

        Route::resource('/subscriptions', SubscriptionsController::class);

        Route::resource('/account-managers', AccountManagerController::class);

        Route::resource('mails', MailController::class);
        Route::get('/fetch-emails',[MailController::class , 'fetch_emails'])->name('fetch-emails');

        Route::resource('/conversations',ConversationsController::class);

    });
