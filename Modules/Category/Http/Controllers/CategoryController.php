<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\CategoryRequest;
use Modules\Category\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories)->additional(['status' => 200, 'message' => 'Categories fetched successfully']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $inputs = $request->validated();
        $category = Category::create($inputs);
        return response()->json(new CategoryResource($category), 200)->additional(['status' => 200, 'message' => 'Category created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json(new CategoryResource($category), 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $inputs = $request->validated();
        $category = Category::find($id);
        $category->update($inputs);
        return response()->json(new CategoryResource($category), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(new CategoryResource($category), 200);
    }

}
