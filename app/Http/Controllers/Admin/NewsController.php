<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\NewsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\Category;
use App\Models\Manufacture;
use App\Models\News;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param NewsDataTable $newsDataTable
     * @return Application|Factory|View
     */
    public function index(NewsDataTable $newsDataTable)
    {
        return $newsDataTable->render('admin.components.news.datatable');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $news = new News();
        return view('admin.components.news.create', compact('news'));
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
        $inputs['post_date'] = Carbon::parse($inputs['post_date']);
        $validator = Validator::make($inputs, News::$cast);
        if ($validator->fails()) {
            return redirect()->route('news.create')->withErrors($validator)->withInput();
        }
        $news = News::create($inputs);
        $news->slug = Str::slug($inputs['title_en'], '-') .'-'. $news->created_at->timestamp;
        $news->save();

        return redirect()->route('news.index')->with(['success' => 'News ' . __("messages.add")]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::findOrFail($id);
        $news = new NewsResource($news);
        return view('admin.components.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.components.news.edit', compact('news'));
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
        $news = News::find($id);
        $news->update($inputs);
        $news->slug = Str::slug($inputs['title_en'], '-') .'-'. $news->created_at->timestamp;
        $news->save();

        return redirect()->route('news.index')->with(['success' => 'News ' . __("messages.update")]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return redirect()->back()->with(['success' => 'News ' . __("messages.delete")]);
    }
}
