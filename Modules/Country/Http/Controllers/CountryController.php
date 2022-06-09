<?php

namespace Modules\Country\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Country\Entities\Country;
use Modules\Country\Http\Requests\CountryRequest;
use Modules\Country\Http\Resources\CountryResource;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->header('X-localization') == 'ar'){
            $countries = Country::all()->sortBy('title_ar');;
        }
        elseif ($request->header('X-localization') == 'en') {
            $countries = Country::all()->sortBy('title_en');;
        }
        else{
            $countries = Country::all()->sortBy('title_ar');;
        }
        return CountryResource::collection($countries)->additional(['status' => 200, 'message' => 'Countries fetched successfully']);
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request)
    {
        $inputs = $request->validated();
        $country = Country::create($inputs);
        return response()->json(new CountryResource($country), 200);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $country = Country::findOrFail($id);
        return response()->json(new CountryResource($country), 200);
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, $id)
    {
        $inputs = $request->validated();
        $country = Country::find($id);
        $country->update($inputs);
        return response()->json(new CountryResource($country), 200);
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        $country->delete();
        return response()->json(new CountryResource($country), 200);
    }

}
