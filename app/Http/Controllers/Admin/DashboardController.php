<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\VisitorInformationController;
use App\Models\VisitorInformation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        return view("admin.components.dashboard.index");
    }
}
