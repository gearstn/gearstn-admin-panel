<?php

namespace Modules\Manufacture\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Manufacture\Entities\Manufacture;
use Modules\Manufacture\Http\Requests\StoreManufactureRequest;
use Modules\Manufacture\Http\Resources\ManufactureResource;

class ManufactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $manufacture =  Manufacture::all();
        return ManufactureResource::collection($manufacture)->additional(['status' => 200, 'message' => 'Manufactures fetched successfully']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreManufactureRequest $request)
    {
        $inputs = $request->validated();
        $manufacture = Manufacture::create($inputs);
        return response()->json(new ManufactureResource($manufacture),200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $manufacture = Manufacture::findOrFail($id);
        return response()->json(new ManufactureResource($manufacture),200);
    }
}
