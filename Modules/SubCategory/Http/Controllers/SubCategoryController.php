<?php

namespace Modules\SubCategory\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Category\Entities\Category;
use Modules\SubCategory\Entities\SubCategory;
use Modules\SubCategory\Http\Resources\SubCategoryResource;

class SubCategoryController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, ['category' => 'required'] );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $category_name = $inputs['category'];
        $category = Category::where('title_en',$category_name)->orWhere('title_ar',$category_name)->first()->id;
        $sub_categories = SubCategory::where('category_id',$category)->get();
        return SubCategoryResource::collection($sub_categories)->additional(['status' => 200, 'message' => 'SubCategories fetched successfully']);
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
}
