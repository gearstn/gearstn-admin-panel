<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CitiesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CitiesDataTable $categoriesDataTable
     * @return Application|Factory|View
     */
    public function index(CitiesDataTable $citiesDataTable)
    {
        return $citiesDataTable->render('admin.components.city.datatable');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $city = new City();
        return view('admin.components.city.create', compact('city'));

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
        $validator = Validator::make($inputs, City::$cast);
        if ($validator->fails()) {
            return redirect()->route('cities.create')->withErrors($validator)->withInput();
        }
        $city = City::create($inputs);

        return redirect()->route('cities.index')->with(['success' => 'City ' . __("messages.add")]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::findOrFail($id);
        $city = new CityResource($city);
        return view('admin.components.city.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::findOrFail($id);
        return view('admin.components.city.edit', compact('city'));
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
        $city = City::find($id);
        $city->update($inputs);
        return redirect()->route('cities.index')->with(['success' => 'City ' . __("messages.update")]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return redirect()->back()->with(['success' => 'City ' . __("messages.delete")]);
    }
}
