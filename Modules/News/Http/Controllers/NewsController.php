<?php

namespace Modules\News\Http\Controllers;

use App\Classes\POST_Caller;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Machine\Entities\Machine;
use Modules\News\Entities\News;
use Modules\News\Http\Requests\LatestNewsRequest;
use Modules\News\Http\Resources\NewsResource;
use Illuminate\Support\Str;
use Modules\News\Http\Requests\NewsRequest;
use Modules\Upload\Http\Controllers\UploadController;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(number_in_page());
        return NewsResource::collection($news)->additional(['status' => 200, 'message' => 'News fetched successfully']);
        // $data = $this->test(Machine::class);
        // return new JsonResponse($data);
    }


    public function test($model)
    {
        $data = $model::all();
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        $inputs = $request->validated();
        $data = [
            'photos' => $inputs['image'],
            'seller_id' => Auth::user()->id,
            'path' => 'news'
        ];
        //Uploading News Image
        $post = new POST_Caller(UploadController::class, 'store', StoreUploadRequest::class, $data);
        $response = $post->call();
        if ($response->status() != 200) {return $response;}
        $inputs['image_id'] = $response->getContent();
        unset($inputs['image']);

        $news = News::create($inputs);
        $news->slug = Str::slug($inputs['title_en'], '-') .'-'. $news->created_at->timestamp;
        $news->save();
        return response()->json(new NewsResource($news), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $news = News::findOrFail($id);
        return response()->json(new NewsResource($news), 200);
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, $id)
    {
        $inputs = $request->validated();
        $inputs['post_date'] = Carbon::parse($inputs['post_date']);
        $news = News::find($id);
        $news->update($inputs);
        return response()->json(new NewsResource($news), 200);
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
        return response()->json(new NewsResource($news), 200);
    }

    public function latest_news(LatestNewsRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $inputs = $request->validated();
        $news = News::orderBy('created_at', 'desc')->take((int)$inputs['number'])->get();
        return NewsResource::collection($news)->additional(['status' => 200, 'message' => 'News fetched successfully']);
    }

}
