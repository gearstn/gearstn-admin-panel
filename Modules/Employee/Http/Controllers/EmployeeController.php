<?php

namespace Modules\Employee\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Employee\Entities\Employee;
use Modules\Employee\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::paginate(number_in_page());
        return EmployeeResource::collection($employees)->additional(['status' => 200, 'message' => 'Employees fetched successfully']);
    }
}
