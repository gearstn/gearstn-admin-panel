<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        if(isset($inputs['file'])) $inputs['photos'][] = $inputs['file'];

        $validator = Validator::make($inputs, [
            "photos" => ["required","array","min:1","max:5"],
            "photos.*" => ["required","mimes:jpeg,jpg,png,gif","max:500"],
        ] );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $images = [];
        foreach ($inputs['photos'] as $image) {
            $fileInfo = $image->getClientOriginalName();
            $newFileName = time() . '.' . $image->extension();
            $path = Storage::disk('s3')->put('images', $image);
            $url = Storage::disk('s3')->url($path);
            $photo = [
                'user_id' => isset($inputs['seller_id']) ? $inputs['seller_id'] : Auth::user()->id ,
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Request $request)
    {
        $inputs = $request->all();
        // foreach($inputs['ids'] as $id){
            $image = Upload::find($inputs['ids']);
            Storage::disk('s3')->delete($image->file_path);
            $image->delete();
        // }
        return redirect()->back();
    }
    public function user_destroy(Request $request)
    {
        $inputs = $request->all();

        $image = Upload::find($inputs['id']);
        $user = User::find($image->user_id);
        $user->{$inputs['key']} = null;
        $user->save();
        Storage::disk('s3')->delete($image->file_path);
        $image->delete();
        return redirect()->back();
    }
}
