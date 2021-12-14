<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MachineModelsDataTable;
use App\Http\Controllers\Controller;
use App\Models\MachineModel;
use App\Models\Manufacture;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MachineModelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param MachineModelsDataTable $machinemodelsDataTable
     * @return Application|Factory|View
     *
     */
    public function index(MachineModelsDataTable $machinemodelsDataTable)
    {
        return $machinemodelsDataTable->render('admin.components.machine-model.datatable');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $machine_model = new MachineModel();
        $manufactures = Manufacture::all()->pluck("title_en", "id");
        return view('admin.components.machine-model.create', compact('machine_model','manufactures'));
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
        $inputs['sub_category_id'] = Manufacture::find($inputs['manufacture_id'])->sub_category_id;
        $inputs['category_id'] = SubCategory::find($inputs['sub_category_id'])->category_id;
        $validator = Validator::make($inputs, MachineModel::$cast);
        if ($validator->fails()) {
            return redirect()->route('machine-models.create')->withErrors($validator)->withInput();
        }
        $machine_model = MachineModel::create($inputs);
        return redirect()->route('machine-models.index')->with(['success' => 'Machine Model ' . __("messages.add")]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $machine_model = MachineModel::findOrFail($id);
        return view('admin.components.machine-model.show', compact('machine_model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $machine_model = MachineModel::findOrFail($id);
        $manufactures = Manufacture::all()->pluck("title_en", "id");
        return view('admin.components.machine-model.edit', compact('machine_model','manufactures'));
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
        $inputs['sub_category_id'] = Manufacture::find($inputs['manufacture_id'])->sub_category_id;
        $inputs['category_id'] = SubCategory::find($inputs['sub_category_id'])->category_id;

        $machine_model = MachineModel::find($id);
        $machine_model->update($inputs);
        return redirect()->route('machine-models.index')->with(['success' => 'Machine Model ' . __("messages.update")]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $machine_model = MachineModel::findOrFail($id);
        $machine_model->delete();
        return redirect()->back()->with(['success' => 'Machine Model ' . __("messages.delete")]);
    }
}
