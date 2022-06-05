<?php

namespace Modules\ServiceType\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Modules\ServiceType\Entities\ServiceType;
use Modules\ServiceType\Http\Resources\ServiceTypeResource;
class ServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $service_types = ServiceType::paginate(number_in_page());
        return ServiceTypeResource::collection($service_types)->additional(['status' => 200, 'message' => 'Models fetched successfully']);
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
            'title_en' => 'required|unique:service_types',
            'title_ar' => 'required'
        ] );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $service_type = ServiceType::create($inputs);
        return response()->json(new ServiceTypeResource($service_type), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $service_type = ServiceType::findOrFail($id);
        return response()->json(new ServiceTypeResource($service_type),200);
    }
}
