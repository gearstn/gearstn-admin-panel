<?php

namespace Modules\Upload\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Modules\Upload\Entities\Upload;
use Modules\Upload\Http\Requests\StoreUploadRequest;
use Modules\Upload\Http\Requests\DestroyUploadRequest;
use Modules\Upload\Http\Requests\StoreFileRequest;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        if(isset($inputs['file'])) $inputs['photos'][] = $inputs['file'];


        $validator = Validator::make($inputs, [
            // "photos" => ["required","array","min:1","max:5"],
            // "photos.*" => ["required","mimes:jpg,png,jpeg,gif,svg","max:1000"],
            'seller_id' => 'sometimes'
        ] );

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $images = [];
        foreach ($inputs['photos'] as $image) {

            $fileInfo = $image->getClientOriginalName();
            $newFileName = time() . '.' . $image->extension();
            if ($image->getSize() /1024 > 250.0){
                $img = Image::make($image)->insert( storage_path('app/public/logo.png') , 'bottom-right')->limitColors(256)->gamma(1.0)->encode($image->extension());
            }
            else{
                $img = Image::make($image)->insert( storage_path('app/public/logo.png') , 'bottom-right')->encode($image->extension());
            }

            Storage::disk('s3')->put($inputs['seller_id'] .'/'. $newFileName,   (string)$img);
            $path = $inputs['seller_id'] .'/'. $newFileName;
            $url = Storage::disk('s3')->url($path);
            $photo = [
                'user_id' => $inputs['seller_id'] ?? Auth::user()->id,
                'file_original_name' => pathinfo($fileInfo, PATHINFO_FILENAME),
                'extension' => pathinfo($fileInfo, PATHINFO_EXTENSION),
                'file_name' => $newFileName,
                'type' => $image->getMimeType(),
                'url' => $url,
                'file_path' => $path,
            ];
            $images[] = Upload::create($photo)->id;
        }
        return response()->json($images,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(DestroyUploadRequest $request): \Illuminate\Http\RedirectResponse
    {
        $inputs = $request->validated();
        // foreach($inputs['ids'] as $id){
            $image = Upload::find($inputs['ids']);
            Storage::disk('s3')->delete($image->file_path);
            $image->delete();
        // }
        return redirect()->back();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFileRequest $request
     * @return JsonResponse
     */
    public function upload_report_file(StoreFileRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        foreach ($inputs['file'] as $image) {
            $fileInfo = $image->getClientOriginalName();
            $newFileName = time() . '.' . $image->extension();
            $path = Storage::disk('s3')->put('machine_reports', $image);
            $url = Storage::disk('s3')->url($path);
            $photo = [
                'user_id' => $inputs['seller_id'] ?? Auth::user()->id,
                'file_original_name' => pathinfo($fileInfo, PATHINFO_FILENAME),
                'extension' => pathinfo($fileInfo, PATHINFO_EXTENSION),
                'file_name' => $newFileName,
                'type' => 'file',
                'url' => $url,
                'file_path' => $path,
            ];
            $file = Upload::create($photo)->id;
        }
        return response()->json($file,200);
    }


        /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function upload_video(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            "videos" => ["required","array","min:1"],
            // "photos.*" => ["required","mimes:jpg,png,jpeg,gif,svg","max:1000"],
            'seller_id' => 'sometimes'
        ] );

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        foreach ($inputs['videos'] as $video) {
            $fileInfo = $video->getClientOriginalName();
            $newFileName = time() . '.' . $video->extension();

            Storage::disk('local')->put($inputs['seller_id'] .'/'. $newFileName,   (string)$video);
            $path = $inputs['seller_id'] .'/'. $newFileName;
            $url = Storage::disk('local')->url($path);
            $video_file = [
                'user_id' => $inputs['seller_id'] ?? Auth::user()->id,
                'file_original_name' => pathinfo($fileInfo, PATHINFO_FILENAME),
                'extension' => pathinfo($fileInfo, PATHINFO_EXTENSION),
                'file_name' => $newFileName,
                'type' => $video->getMimeType(),
                'url' => $url,
                'file_path' => $path,
            ];
            $videos[] = Upload::create($video_file)->id;
        }
        return response()->json($videos,200);
    }
}
