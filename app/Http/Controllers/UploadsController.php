<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\User;
use Intervention\Image\Facades\Image;
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
            "photos.*" => ["required","mimes:jpeg,jpg,png,gif","max:1000"],
        ] );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $images = [];
        foreach ($inputs['photos'] as $image)
        {
            $fileInfo = $image->getClientOriginalName();
            $newFileName = time() . '.' . $image->extension();
            if ($image->getSize() /1024 > 250.0){
                $img = Image::make($image)->insert( storage_path('app/public/logo.png') , 'bottom-right')->limitColors(256)->gamma(1.0)->encode($image->extension());
            }
            else{
                $img = Image::make($image)->insert( storage_path('app/public/logo.png') , 'bottom-right')->encode($image->extension());
            }
            $id = isset($inputs['seller_id']) ? $inputs['seller_id'] : Auth::user()->id ;
            Storage::disk('s3')->put($id .'/'. $newFileName,   (string)$img);
            $path = $id .'/'. $newFileName;
            $url = Storage::disk('s3')->url($path);
            $photo = [
                'user_id' => $id,
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

public function local_upload(Request $request){
    if($request->hasFile('upload')) {
        //get filename with extension
        $filenamewithextension = $request->file('upload')->getClientOriginalName();

        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $request->file('upload')->getClientOriginalExtension();

        //filename to store
        $filenametostore = $filename.'_'.time().'.'.$extension;

        //Upload File
        $request->file('upload')->storeAs('public/uploads', $filenametostore);

        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        $url = asset('storage/uploads/'.$filenametostore);
        $msg = 'Image successfully uploaded';
        $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

        // Render HTML output
        @header('Content-type: text/html; charset=utf-8');
        echo $re;
    }
}


}
