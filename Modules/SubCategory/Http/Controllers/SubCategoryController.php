<?php

namespace Modules\SubCategory\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Category\Entities\Category;
use Modules\SubCategory\Entities\SubCategory;
use Modules\SubCategory\Http\Requests\SubCategoryRequest;
use Modules\SubCategory\Http\Resources\SubCategoryResource;

class SubCategoryController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sub_categories = SubCategory::paginate(number_in_page());
        return SubCategoryResource::collection($sub_categories)->additional(['status' => 200, 'message' => 'SubCategories fetched successfully']);
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
