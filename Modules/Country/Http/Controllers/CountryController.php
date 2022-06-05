<?php

namespace Modules\Country\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Country\Entities\Country;
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
}
