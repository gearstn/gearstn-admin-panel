<?php

namespace Modules\SubCategory\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Category\Entities\Category;
use Modules\Manufacture\Entities\Manufacture;
use Modules\Manufacture\Http\Resources\ManufactureResource;
use Modules\SubCategory\Entities\SubCategory;
use Modules\SubCategory\Http\Requests\SubCategoryRequest;
use Modules\SubCategory\Http\Resources\SubCategoryResource;

class SubCategoryController extends Controller
{
        /**
     * Display a listing of the resource with pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sub_categories = SubCategory::paginate(number_in_page());
        return SubCategoryResource::collection($sub_categories)->additional(['status' => 200, 'message' => 'SubCategories fetched successfully']);
    }

    /**
     * Display a listing of the resource without pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_all(){
        $sub_categories = SubCategory::all();
        return SubCategoryResource::collection($sub_categories)->additional(['status' => 200, 'message' => 'SubCategories fetched successfully']);
    }


    /**
     * Display a listing of the subcategories for select.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_subcategories_filtered(){
        $sub_categories = SubCategory::all()->pluck('title_en', 'id');
        return response()->json(['sub_categories' => $sub_categories], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoryRequest $request)
    {
        $inputs = $request->validated();
        $sub_category = SubCategory::create($inputs);

        //Attaching MAnufactures to SubCategory if Selected
        if (isset($inputs['manufactures'])) {
            foreach ($inputs['manufactures'] as $manufacture_id) {
                $sub_category->manufactures()->attach($manufacture_id);
                $sub_category->save();
            }
        }

        return response()->json(new SubCategoryResource($sub_category), 200)->additional(['status' => 200, 'message' => 'Category created successfully']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sub_category = SubCategory::findOrFail($id);
        return response()->json(new SubCategoryResource($sub_category),200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sub_category = SubCategory::findOrFail($id);
        $sub_category_category = Category::find($sub_category->category_id)->pluck('title_en','id');
        $sub_category_manufactures = $sub_category->manufactures()->pluck('id','title_en');
        return response()->json([ 'sub_category' => new SubCategoryResource($sub_category),
                                  'sub_category_manufactures' => $sub_category_manufactures,
                                  'sub_category_category' => $sub_category_category,
                                ],200);
    }

       /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoryRequest $request, $id)
    {
        $inputs = $request->validated();
        $sub_category = SubCategory::find($id);
        $sub_category->update($inputs);
        //Attaching Manufactures to SubCategory if Selected
        if (isset($inputs['manufactures'])) {
            $sub_category->manufactures()->detach();
            foreach ($inputs['manufactures'] as $manufacture_id) {
                $sub_category->manufactures()->attach($manufacture_id);
                $sub_category->save();
            }
        }
        return response()->json(new SubCategoryResource($sub_category), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sub_category = SubCategory::findOrFail($id);
        $sub_category->delete();
        return response()->json(new SubCategoryResource($sub_category), 200);
    }

}
