<?php

namespace Modules\User\Http\Controllers;

use App\Classes\POST_Caller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Modules\Upload\Http\Controllers\UploadController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Upload\Http\Requests\StoreUploadRequest;
use Modules\User\Http\Resources\FullUserResource;
use Modules\User\Http\Resources\NormalUserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Machine\Entities\Machine;
use Modules\User\Entities\AcountManagerRequest;
use Modules\User\Http\Requests\StoreAccountManagerRequest;
use Modules\User\Http\Requests\User\ChangePasswordRequest;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function getNormalUser(): JsonResponse
    {
        $id  = Auth::user()->id;
        $user = User::findOrFail($id);
        return response()->json(new NormalUserResource($user), 200);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function getFullUser(): JsonResponse
    {
        $id  = Auth::user()->id;
        $user = User::findOrFail($id);
        return response()->json(new FullUserResource($user), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function update(Request $request)
    {
        $inputs = $request->all();
        $user = Auth::user();

        //For distributor it is required to upload tax_license_image & commercial_license_image
        if ($user->hasRole('distributor') && $user->tax_license_image === null && $user->commercial_license_image === null) {
            $validator = Validator::make($inputs, [
                'tax_license' => 'required',
                'tax_license_image' => 'required',
                'commercial_license' => 'required',
                'commercial_license_image' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->messages(), 400);
            }

            //Adding Tax License Image
            $data = [
                'photos' => [$inputs['tax_license_image']],
                'seller_id' => $user->id,
            ];
            $post = new Post_Caller(UploadController::class,'store',StoreUploadRequest::class,$data);
            $response = $post->call();

            if($response->status() != 200) { return $response; }
            $inputs['tax_license_image'] = json_decode($response->getContent())[0];



            //Adding Commercial License Image
            $data = [
                'photos' => [$inputs['commercial_license_image']],
                'seller_id' => $user->id,
            ];
            $post = new Post_Caller(UploadController::class,'store',StoreUploadRequest::class,$data);
            $response = $post->call();
            if($response->status() != 200) { return $response; }
            $inputs['commercial_license_image'] = json_decode($response->getContent())[0];

        }

        //For contractor it is required to upload national_id_image
        if ($user->hasRole('contractor') && $user->national_id_image === null) {
            $validator = Validator::make($inputs, [
                'national_id' => 'required',
                'national_id_image' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->messages(), 400);
            }

            //Adding National License Image
            $data = [
                'photos' => [$inputs['national_id_image']],
                'seller_id' => $user->id,
            ];
            $post = new Post_Caller(UploadController::class,'store',StoreUploadRequest::class,$data);
            $response = $post->call();
            if($response->status() != 200) { return $response; }
            $inputs['national_id_image'] = json_decode($response->getContent())[0];

        }

        $user->update($inputs);
        $user->save();
        return response()->json(['message' => 'Profile Updated Successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'Profile Deleted Successfully'], 200);
    }


    /**
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function change_password(ChangePasswordRequest $request): JsonResponse
    {
        $input = $request->all();
        $user_id = Auth::user()->id;
        try {
            if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                $arr = array("status" => 400, "message" => "Check your old password and enter it correctly.");
            } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
            } else {
                User::where('id', $user_id)->update(['password' => Hash::make($input['new_password'])]);
                $arr = array("status" => 200, "message" => "Password updated successfully.");
            }
        } catch (\Exception $ex) {
            if (isset($ex->errorInfo[2])) {
                $msg = $ex->errorInfo[2];
            } else {
                $msg = $ex->getMessage();
            }
            $arr = array("status" => 400, "message" => $msg, "data" => array());
        }
        return response()->json($arr);
    }


    public function request_account_manager(StoreAccountManagerRequest $request): JsonResponse
    {
        $user_id = Auth::user()->id;
        $inputs = $request->validated();
        $inputs['user_id'] = $user_id;

        AcountManagerRequest::create($inputs);
        return response()->json(['message_en' => 'your request has been created successfully, We will contact you soon',
                                 'message_ar' => 'تم إنشاء طلبك بنجاح ، وسنتصل بك قريبًا'
                                ], 200);
    }

    public function get_phone(Request $request): JsonResponse
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs,  ['seller_id' => 'required','product_id' => 'required','product_type' => 'required']);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $user = User::findOrFail($inputs['seller_id']);

        if($inputs['product_type'] == 'machine'){
            $machine = Machine::where('id', '=', $inputs['product_id'])->firstOrFail();
            $machine->phone_clicks = $machine->phone_clicks + 1;
            $machine->save();
        }
        $phone = $user->phone;
        return response()->json($phone, 200);
    }
}
