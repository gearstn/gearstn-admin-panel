<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ManufacturesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Manufacture;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManufacturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ManufacturesDataTable $manufacturesDataTable
     * @return Application|Factory|View
     *
     */
    public function index(ManufacturesDataTable $manufacturesDataTable)
    {
        return $manufacturesDataTable->render('admin.components.manufacture.datatable');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $manufacture = new Manufacture();
        $categories = Category::all()->pluck("title_en", "id");
        $sub_categories = SubCategory::all()->pluck("title_en", "id");
        return view('admin.components.manufacture.create', compact('manufacture','categories','sub_categories'));
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
        $validator = Validator::make($inputs, Manufacture::$cast);
        if ($validator->fails()) {
            return redirect()->route('manufactures.create')->withErrors($validator)->withInput();
        }
        $manufacture = Manufacture::create($inputs);

        //Attaching SubCategories to Manufacture if Selected
        if (isset($inputs['sub_categories'])) {
            foreach ($inputs['sub_categories'] as $sub_category_id) {
                $manufacture->sub_categories()->attach($sub_category_id);
                $manufacture->save();
            }
        }
        return redirect()->route('manufactures.index')->with(['success' => 'Manufacture ' . __("messages.add")]);
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
        return view('admin.components.manufacture.show', compact('manufacture'));
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
        $categories = Category::all()->pluck("title_en", "id");
        $sub_categories = SubCategory::all()->pluck("title_en", "id");
        return view('admin.components.manufacture.edit', compact('manufacture','categories','sub_categories'));
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

        return redirect()->route('manufactures.index')->with(['success' => 'Manufacture ' . __("messages.update")]);
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
        return redirect()->back()->with(['success' => 'Manufacture ' . __("messages.delete")]);
    }
}
