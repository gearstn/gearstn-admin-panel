<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Machine\Entities\Machine;

class DashboardController extends Controller
{
    public function index()
    {

        $all_users = User::all()->count();
        $today_users = User::whereDate('created_at', Carbon::today())->count();

        $all_machines = Machine::all()->count() ;
        $today_machines = Machine::whereDate('created_at', Carbon::today())->count();

        $total_distributor = User::query()->whereHas("roles", function($q){ $q->where("name", ["distributor"]); })->count();
        $today_distributor = User::query()->whereHas("roles", function($q){ $q->where("name", ["distributor"]); })->whereDate('created_at', Carbon::today())->count();

        $total_contractor = User::query()->whereHas("roles", function($q){ $q->where("name", ["contractor"]); })->count();
        $today_contractor = User::query()->whereHas("roles", function($q){ $q->where("name", ["contractor"]); })->whereDate('created_at', Carbon::today())->count();

        return response()->json([
            'all_users' => $all_users,
            'today_users' => $today_users,
            'all_machines' => $all_machines,
            'today_machines' => $today_machines,
            'total_distributor' => $total_distributor,
            'today_distributor' => $today_distributor,
            'total_contractor' => $total_contractor,
            'today_contractor' => $today_contractor,
        ],200);
    }
}
