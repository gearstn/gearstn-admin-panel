<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\User\Http\Resources\RoleResource;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $roles = Role::all();
        return RoleResource::collection($roles);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        // return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'name' => 'required|unique:roles',
            'guard_name' => 'required',
        ] );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $role = Role::create($inputs);
        return response()->json(new RoleResource($role), 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $role = Role::find($id);
        return response()->json(new RoleResource($role),200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        // return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'name' => 'required|unique:roles',
            'guard_name' => 'required',
            ] );
            if ($validator->fails()) {
                return response()->json($validator->messages(), 400);
            }
        $role = Role::findById($id);
        $role->update($inputs);
        $role->save();
        return response()->json(new RoleResource($role), 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $role = Role::findById($id);
        $role->delete();
        return response()->json(new RoleResource($role), 200);
    }
}
