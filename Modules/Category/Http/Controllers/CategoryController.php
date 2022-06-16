<?php

namespace Modules\Category\Http\Controllers;

use App\Classes\CollectionPaginate;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\CategoryRequest;
use Modules\Category\Http\Resources\CategoryResource;
use Spatie\Searchable\Search;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(number_in_page());
        return CategoryResource::collection($categories)->additional(['status' => 200, 'message' => 'Categories fetched successfully']);
    }

    /**
     * Display a listing of the resource without pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_all(){
        $categories = Category::all();
        return CategoryResource::collection($categories)->additional(['status' => 200, 'message' => 'Categories fetched successfully']);
    }

    public function get_categories_filtered(){
        $categories = Category::all()->pluck('title_en', 'id');
        return response()->json(['categories' => $categories], 200);
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

    public function search(Request $request){
        $inputs = $request->all();

        if (isset($inputs['search_query']) && $inputs['search_query'] != null) {
            $q = (new Search())
                    ->registerModel(Category::class, ['title_en', 'title_ar'])
                    ->search($inputs['search_query']);
            $q = CategoryResource::collection( array_column($q->toArray(), 'searchable') );
        } else {
            $q = Category::all();
        }

        // Sort the collection of categories if requested
        $q = $q->when(isset($inputs['sort_by']) && $inputs['sort_by'] != null, function ($q) use ($inputs) {
            $sort = explode(',', $inputs['sort_by']);
            if ($sort[1] == 'asc') {
                return $q->sortBy($sort[0]);
            } else {
                return $q->SortByDesc($sort[0]);
            }
        });

        $paginatedResult = CollectionPaginate::paginate($q, 10);
        return CategoryResource::collection($paginatedResult)->additional(['status' => 200, 'message' => 'Categories fetched successfully']);
    }

}
