<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Machine\Entities\Machine;
use Modules\Machine\Http\Resources\MachineResource;
use Modules\SparePart\Entities\SparePart;
use Modules\SparePart\Http\Resources\SparePartResource;
use Modules\User\Http\Requests\SaveList\AddToListRequest;
use Modules\User\Http\Requests\SaveList\RemoveFromListRequest;

class SavedListController extends Controller
{
    public function getList(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, ['product_type' => 'required']);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        $user = User::find(auth()->user()->id);
        if( str_contains($inputs['product_type'],'machine')){
            return response()->json(MachineResource::collection($user->wishlist('machines')),200);
        }
        else{
            return response()->json(SparePartResource::collection($user->wishlist('spare-parts')),200);
        }
    }

    public function addToList(AddToListRequest $request)
    {
        $inputs = $request->validated();
        $user = User::find(auth()->user()->id);
        if($inputs['product_type'] == 'machine'){
            $product = Machine::find($inputs['product_id']);
            $user->wish($product,'machines');
            return response()->json($user->wishlist('machines'),200);
        }
        else{
            $product = SparePart::find($inputs['product_id']);
            $user->wish($product,'spare-parts');
            return response()->json($user->wishlist('spare-parts'),200);
        }
    }


    public function removeItem(RemoveFromListRequest $request)
    {
        $inputs = $request->validated();
        $user = User::find(auth()->user()->id);
        if($inputs['product_type'] == 'machine'){
            $product = Machine::find($inputs['product_id']);
            $user->unwish($product,$user->id);
            return response()->json(MachineResource::collection($user->wishlist($user->id)),200);
        }
        else{
            $product = SparePart::find($inputs['product_id']);
            $user->unwish($product,'spare-parts');
            return response()->json(SparePartResource::collection($user->wishlist($user->id)),200);
        }
    }

    public function clearList()
    {
        $user = User::find(auth()->user()->id);
        $machines_whislist = $user->wishlist($user->id);
        foreach($machines_whislist as $machine)
        {
            $user->unwish($machine,$user->id);
        }
        return response()->json(['message' => 'Your list is now empty'],200);
    }
}
