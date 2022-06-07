<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Machine\Entities\Machine;
use Modules\News\Entities\News;
use Modules\News\Http\Requests\LatestNewsRequest;
use Modules\News\Http\Resources\NewsResource;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $news = News::orderBy('created_at', 'desc')->paginate(number_in_page());
        // return NewsResource::collection($news)->additional(['status' => 200, 'message' => 'News fetched successfully']);
        $data = $this->test(Machine::class);
        return new JsonResponse($data);
    }


    public function test($model)
    {
        $data = $model::all();
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return JsonResponse
     */
    public function show($slug): JsonResponse
    {
        $news = News::where('slug', '=', $slug)->firstOrFail();
        return response()->json(new NewsResource($news), 200);
    }

    public function latest_news(LatestNewsRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $inputs = $request->validated();
        $news = News::orderBy('created_at', 'desc')->take((int)$inputs['number'])->get();
        return NewsResource::collection($news)->additional(['status' => 200, 'message' => 'News fetched successfully']);
    }

}
