<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\VisitorInformationController;
use App\Models\Machine;
use App\Models\User;
use App\Models\VisitorInformation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {

        $all_users = User::all()->count();
        $today_users = User::whereDate('created_at', Carbon::today())->count();
        
        $all_machines = Machine::all()->count() ;
        $today_machines = Machine::whereDate('created_at', Carbon::today())->count();

        $total_distributor = User::query()->whereHas("roles", function($q){ $q->whereNotIn("name", ["distributor"]); })->count();
        $today_distributor = User::query()->whereHas("roles", function($q){ $q->whereNotIn("name", ["distributor"]); })->whereDate('created_at', Carbon::today())->count();

        $total_contractor = User::query()->whereHas("roles", function($q){ $q->whereNotIn("name", ["contractor"]); })->count();
        $today_contractor = User::query()->whereHas("roles", function($q){ $q->whereNotIn("name", ["contractor"]); })->whereDate('created_at', Carbon::today())->count();

        return view("admin.components.dashboard.index" , 
                compact('all_users', 'today_users' , 'all_machines' , 'today_machines' , 'total_distributor', 'today_distributor', 'total_contractor', 'today_contractor'));
    }
}
