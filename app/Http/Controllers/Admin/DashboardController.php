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

        $all_users = User::all();
        $today_users = User::whereDate('created_at', Carbon::today());
        
        $all_machines = Machine::all();
        $today_machines = Machine::whereDate('created_at', Carbon::today());

        $total_distributor = User::role('distributor');
        $today_distributor = User::role('distributor')->whereDate('created_at', Carbon::today());

        $total_contractor = User::role('contractor');
        $today_contractor = User::role('contractor')->whereDate('created_at', Carbon::today());

        return view("admin.components.dashboard.index" , 
                compact('all_users', 'today_users' , 'all_machines' , 'today_machines' , 'total_distributor', 'today_distributor', 'total_contractor', 'today_contractor'));
    }
}
