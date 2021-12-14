<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Resources\FullUserResource;
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
        $user = new FullUserResource($user);
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
        return view('admin.components.user.edit', compact('user','roles'));
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
        $user->update($inputs);
        $user->roles()->detach();
        $role = Role::find($inputs['role_id']);
        $user->assignRole($role);

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
