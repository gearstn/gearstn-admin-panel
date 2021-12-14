<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\EmployeesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param EmployeesDataTable $categoriesDataTable
     * @return Application|Factory|View
     */
    public function index(EmployeesDataTable $employeesDataTable)
    {
        return $employeesDataTable->render('admin.components.employee.datatable');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = new Employee();
        return view('admin.components.employee.create', compact('employee'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, Employee::$cast);
        if ($validator->fails()) {
            return redirect()->route('employees.create')->withErrors($validator)->withInput();
        }
        $employee = Employee::create($inputs);

        return redirect()->route('employees.index')->with(['success' => 'Employee ' . __("messages.add")]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        $employee = new EmployeeResource($employee);
        return view('admin.components.employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('admin.components.employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->all();
        $employee = Employee::find($id);
        $employee->update($inputs);
        return redirect()->route('employees.index')->with(['success' => 'Employee ' . __("messages.update")]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->back()->with(['success' => 'Employee ' . __("messages.delete")]);
    }
}
