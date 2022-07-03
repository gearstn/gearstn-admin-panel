<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Machine\Entities\Machine;
use Modules\SparePart\Entities\SparePart;

class DashboardController extends Controller
{
    public function index()
    {

        $all_users = User::all()->count();
        $today_users = User::whereDate('created_at', Carbon::today())->count();

        $all_machines = Machine::all()->count() ;
        $today_machines = Machine::whereDate('created_at', Carbon::today())->count();

        $all_spareparts = SparePart::all()->count() ;
        $today_spareparts = SparePart::whereDate('created_at', Carbon::today())->count();

        $total_distributor = User::query()->whereHas("roles", function($q){ $q->where("name", ["distributor"]); })->count();
        $today_distributor = User::query()->whereHas("roles", function($q){ $q->where("name", ["distributor"]); })->whereDate('created_at', Carbon::today())->count();

        $total_contractor = User::query()->whereHas("roles", function($q){ $q->where("name", ["contractor"]); })->count();
        $today_contractor = User::query()->whereHas("roles", function($q){ $q->where("name", ["contractor"]); })->whereDate('created_at', Carbon::today())->count();

        $response = [
            'users' => [['title' => 'all users', 'count' => $all_users],
            ['title' => 'Registered Today', 'count' => $today_users]],
            
            'machines' => [['title' => 'all machines', 'count' => $all_machines],
            ['title' => 'Listed Today', 'count' => $today_machines]],
            
            'spare_parts' => [['title' => 'all spare parts', 'count' => $all_spareparts],
            ['title' => 'Listed Today', 'count' => $today_spareparts]],

            'distributor' => [['title' => 'total distributor', 'count' => $total_distributor],
            ['title' => 'Registered Today', 'count' => $today_distributor]],

            'contractor' => [['title' => 'total contractor', 'count' => $total_contractor],
            ['title' => 'Registered Today', 'count' => $today_contractor]],
        ];
        return response()->json($response,200);
    }
}
