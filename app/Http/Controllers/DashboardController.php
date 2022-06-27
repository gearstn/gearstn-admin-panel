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

        $response = [
            'users' => [['title' => 'all_users', 'count' => $all_users],
            ['title' => 'today_users', 'count' => $today_users]],
            'machines' => [['title' => 'all_machines', 'count' => $all_machines],
            ['title' => 'today_machines', 'count' => $today_machines]],
            'distributor' => [['title' => 'total_distributor', 'count' => $total_distributor],
            ['title' => 'today_distributor', 'count' => $today_distributor]],
            'contractor' => [['title' => 'total_contractor', 'count' => $total_contractor],
            ['title' => 'today_contractor', 'count' => $today_contractor]],
        ];
        return response()->json($response,200);
    }
}
