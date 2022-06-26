<?php

namespace Modules\Manufacture\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Category\Entities\Category;
use Modules\Manufacture\Entities\Manufacture;
use Modules\Manufacture\Http\Requests\ManufactureRequest;
use Modules\Manufacture\Http\Requests\StoreManufactureRequest;
use Modules\Manufacture\Http\Requests\UpdateManufactureRequest;
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
        $manufacture =  Manufacture::paginate(number_in_page());
        return ManufactureResource::collection($manufacture)->additional(['status' => 200, 'message' => 'Manufactures fetched successfully']);
    }

    /**
     * Display a listing of the resource without pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_all(){
        $manufacture =  Manufacture::all();
        return ManufactureResource::collection($manufacture)->additional(['status' => 200, 'message' => 'Manufactures fetched successfully']);
    }

    /**
     * Display a listing of the manufactures for select.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_manufacture_filtered(){
        $manufactures =  Manufacture::all()->pluck('title_en', 'id');
        return response()->json(['manufactures' => $manufactures], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(ManufactureRequest $request)
    {
        $inputs = $request->validated();
        $manufacture = Manufacture::create($inputs);

        //Attaching SubCategories to Manufacture if Selected

        if (isset($inputs['sub_categories'])) {
            foreach ($inputs['sub_categories'] as $sub_category_id) {
                $manufacture->sub_categories()->attach($sub_category_id);
                $manufacture->save();
            }
        }

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manufacture = Manufacture::findOrFail($id);
        $manufacture_category = Category::find($manufacture->category_id)->pluck('title_en','id');
        $manufacture_subcategories = $manufacture->sub_categories()->pluck('id','title_en');
        return response()->json([ 'manufacture' => new ManufactureResource($manufacture),
                                  'manufacture_subcategories' => $manufacture_subcategories,
                                  'manufacture_category' => $manufacture_category,
                                ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateManufactureRequest $request, $id)
    {
        $inputs = $request->validated();
        $manufacture = Manufacture::find($id);
        $manufacture->update($inputs);
        //Attaching SubCategories to Manufacture if Selected

        if (isset($inputs['sub_categories'])) {
            $manufacture->sub_categories()->detach();
            foreach ($inputs['sub_categories'] as $sub_category_id) {
                $manufacture->sub_categories()->attach($sub_category_id);
                $manufacture->save();
            }
        }

        return response()->json(new ManufactureResource($manufacture), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manufacture = Manufacture::findOrFail($id);
        $manufacture->delete();
        return response()->json(new ManufactureResource($manufacture), 200);
    }

}
