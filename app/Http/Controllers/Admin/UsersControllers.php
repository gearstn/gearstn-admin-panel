<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadsController;
use App\Http\Resources\FullUserResource;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UsersControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UsersDataTable $usersDataTable
     * @return Application|Factory|View
     */
    public function index(UsersDataTable $usersDataTable)
    {
        return $usersDataTable->render('admin.components.user.datatable');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $roles = Role::all()->pluck('name','id');
        return view('admin.components.user.create', compact('user','roles'));
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
        $validator = Validator::make($inputs, User::$cast);
        if ($validator->fails()) {
            return redirect()->route('users.create')->withErrors($validator)->withInput();
        }

        $role = Role::find($inputs['role_id'])->first();
        $user = User::create($inputs);
        $user->assignRole($role);

        return redirect()->route('users.index')->with(['success' => 'User ' . __("messages.add")]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.components.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all()->pluck('name','id');
        $images = [
            'tax_license_image' => null,
            'commercial_license_image' => null,
            'national_id_image' => null,
        ];
        $images['tax_license_image'] = Upload::find($user->tax_license_image);
        $images['commercial_license_image'] = Upload::find($user->commercial_license_image);
        $images['national_id_image'] = Upload::find($user->national_id_image);

        return view('admin.components.user.edit', compact('user','roles','images'));
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
        $user = User::find($id);

        $user->roles()->detach();
        $role = Role::find($inputs['role_id']);
        $user->assignRole($role);

         //For distributor it is required to upload tax_license_image & commercial_license_image
        if ($user->hasRole('distributor') && $user->tax_license_image === null && $user->commercial_license_image === null) {
            $validator = Validator::make($inputs, [
                'tax_license' => 'required',
                'tax_license_image' => 'required',
                'commercial_license' => 'required',
                'commercial_license_image' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            //Uploads route to upload images and get array of ids
            $uploads_controller = new UploadsController();
            $request = new Request([
                'photos' => [$inputs['tax_license_image']],
                'seller_id' => $user->id,
            ]);
            $response = $uploads_controller->store($request);
            if($response->status() != 200) { return redirect()->back()->withErrors($response)->withInput(); }
            $inputs['tax_license_image'] = json_decode($response->getContent())[0];

            //Uploads route to upload images and get array of ids
            $uploads_controller = new UploadsController();
            $request = new Request([
                'photos' => [$inputs['commercial_license_image']],
                'seller_id' => $user->id,
            ]);
            $response = $uploads_controller->store($request);
            if($response->status() != 200) { return redirect()->back()->withErrors($response)->withInput(); }
            $inputs['commercial_license_image'] = json_decode($response->getContent())[0];

            $inputs['national_id'] = null;
            $inputs['national_id_image'] = null;
        }

        //For contractor it is required to upload national_id_image
        if ($user->hasRole('contractor') && $user->national_id_image === null) {
            $validator = Validator::make($inputs, [
                'national_id' => 'required',
                'national_id_image' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            //Uploads route to upload images and get array of ids
            $uploads_controller = new UploadsController();
            $request = new Request([
                'photos' => [$inputs['national_id_image']],
                'seller_id' => $user->id,
            ]);
            $response = $uploads_controller->store($request);
            if($response->status() != 200) { return redirect()->back()->withErrors($response)->withInput(); }
            $inputs['national_id_image'] = json_decode($response->getContent())[0];

            $inputs['tax_license'] = null;
            $inputs['tax_license_image'] = null;
            $inputs['commercial_license'] = null;
            $inputs['commercial_license_image'] = null;
        }
        $user->update($inputs);

        return redirect()->route('users.index')->with(['success' => 'User ' . __("messages.update")]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach();
        $user->delete();
        return redirect()->back()->with(['success' => 'User ' . __("messages.delete")]);
    }

}
