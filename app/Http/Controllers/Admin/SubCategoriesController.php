<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubCategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubCategoryResource;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SubCategoriesDataTable $subCategoriesDataTable
     * @return Application|Factory|View
     *
     */
    public function index(SubCategoriesDataTable $subCategoriesDataTable)
    {
        return $subCategoriesDataTable->render('admin.components.sub_category.datatable');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sub_category = new SubCategory();
        $categories = Category::all()->pluck("title_en", "id");
        return view('admin.components.sub_category.create', compact('sub_category','categories'));
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
        $validator = Validator::make($inputs, SubCategory::$cast);
        if ($validator->fails()) {
            return redirect()->route('sub-categories.create')->withErrors($validator)->withInput();
        }
        $sub_category = SubCategory::create($inputs);
        return redirect()->route('sub-categories.index')->with(['success' => 'SubCategory ' . __("messages.add")]);
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
        return view('admin.components.sub_category.show', compact('sub_category'));
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
        $categories = Category::all()->pluck("title_en", "id");
        return view('admin.components.sub_category.edit', compact('sub_category','categories'));
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
        $sub_category = SubCategory::find($id);
        $sub_category->update($inputs);
        return redirect()->route('sub-categories.index')->with(['success' => 'SubCategory ' . __("messages.update")]);
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
        return redirect()->back()->with(['success' => 'SubCategory ' . __("messages.delete")]);
    }

}
