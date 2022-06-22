<?php

namespace Modules\MachineModel\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\MachineModel\Entities\MachineModel;
use Modules\MachineModel\Http\Requests\FilterMachineModelRequest;
use Modules\MachineModel\Http\Requests\UpdateMachineModelRequest;
use Modules\MachineModel\Http\Resources\MachineModelResource;


class MachineModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $models = MachineModel::paginate(number_in_page());
        return MachineModelResource::collection($models)->additional(['status' => 200, 'message' => 'Models fetched successfully']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'title_en' => 'required|unique:machine_models',
            'title_ar' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'manufacture_id' => 'required',
        ] );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $machine_model = MachineModel::create($inputs);
        return response()->json(new MachineModelResource($machine_model), 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $models = MachineModel::findOrFail($id);
        return response()->json(new MachineModelResource($models),200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMachineModelRequest $request, $id)
    {
        $inputs = $request->validated();
        $model = MachineModel::find($id);
        $model->update($inputs);
        return response()->json(new MachineModelResource($model), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = MachineModel::findOrFail($id);
        $model->delete();
        return response()->json(new MachineModelResource($model), 200);
    }


    //Get models based on sub_category_id && manufacture_id
    public function filter_models(FilterMachineModelRequest $request)
    {
        $inputs = $request->validated();
        $models = MachineModel::where('sub_category_id',$inputs['sub_category_id'])->where('manufacture_id',$inputs['manufacture_id'])->get();
        return MachineModelResource::collection($models)->additional(['status' => 200, 'message' => 'Models fetched successfully']);
    }
}
