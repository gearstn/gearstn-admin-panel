<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Http\Requests\SettingRequest;
use Modules\Setting\Http\Resources\SettingResource;

class SettingController extends Controller
{
           /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::all();
        return SettingResource::collection($settings)->additional(['status' => 200, 'message' => 'Settings fetched successfully']);
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingRequest $request)
    {
        $inputs = $request->validated();
        $setting = Setting::create($inputs);
        return response()->json(new SettingResource($setting), 200)->additional(['status' => 200, 'message' => 'Category created successfully']);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $setting = Setting::findOrFail($id);
        return response()->json(new SettingResource($setting), 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SettingRequest $request, $id)
    {
        $inputs = $request->validated();
        $setting = Setting::find($id);
        $setting->update($inputs);
        return response()->json(new SettingResource($setting), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        $setting->delete();
        return response()->json(new SettingResource($setting), 200);
    }
}
