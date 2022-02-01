<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CategoriesDataTable $categoriesDataTable
     * @return Application|Factory|View
     */
    public function index(CategoriesDataTable $categoriesDataTable)
    {
        return $categoriesDataTable->render('admin.components.category.datatable');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        return view('admin.components.category.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, Category::$cast);
        if ($validator->fails()) {
            return redirect()->route('categories.create')->withErrors($validator)->withInput();
        }
        $category = Category::create($inputs);

        return redirect()->route('categories.index')->with(['success' => 'Category ' . __("messages.add")]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $category = new CategoryResource($category);
        return view('admin.components.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.components.category.edit', compact('category'));
    }

       /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->all();
        $category = Category::find($id);
        $category->update($inputs);
        return redirect()->route('categories.index')->with(['success' => 'Category ' . __("messages.update")]);
    }

  /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with(['success' => 'Category ' . __("messages.delete")]);
    }

}
