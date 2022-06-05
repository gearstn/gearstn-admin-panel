<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Modules\Country\Entities\Country;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required',
            'country_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $country = Country::find($inputs['country_id']);
        $validator = Validator::make($inputs, [
            'phone' => [
                'required',
                Rule::phone()->detect()->country($country->code),
            ],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        // $inputs['country_id'] = Country::where('code' , $inputs['country_code'])->id;
        $inputs['password'] = bcrypt($inputs['password']);
        $role = Role::find($inputs['role_id']);
        $user = User::create($inputs);
        $user->assignRole($role);
        event(new Registered($user));

        // $token = $user->createToken('API Token')->plainTextToken;
        return response()->json([
            'message_en' => 'You Have registered successfully',
            'message_ar' => 'لقد تم تسجيل الحساب بنجاح',
            'email_verification_en' => 'Please, check your Email to verify your Email',
            'email_verification_ar' => 'من فضلك تحقق من البريد الاكترونى الخاص بك لتاكيد الحساب',
        ],200);
    }


    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        if (!Auth::attempt($attr)) {

            return $this->error('Credentials Error',401,['message_en' => 'Incorrect email or password',
                                              'message_ar' => 'خطء فى البريد الالكترونى او كلمة السر' ]);
        }
        if (Auth::user()->email_verified_at == null) {
            return $this->error('Verification Error',401,['message_en' => 'Email is not verified , please verify your email',
                                              'message_ar' => 'لم يتم التحقق من البريد الإلكتروني ، يرجى التحقق من البريد الإلكتروني الخاص بك' ]);
        }
        $token = auth()->user()->createToken('API Token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'id' => auth()->user()->id,
        ])
        ->withCookie(cookie('_gtn_at', $token, 60 * 60 * 24 * 7, '/',null,false));
    }

    public function logout(): array
    {

        auth()->user()->tokens()->delete();
        $cookie = Cookie::forget('_gtn_at');
        return [
            'message' => 'Tokens Revoked'
        ];
    }

    public function verify(Request $request)
    {
        $inputs = $request->validate([
            'email' => 'required',
        ]);
        $user = User::where('email',$inputs['email'])->first();
        $user->email_verified_at = now();
        $user->save();
        return response()->json([
            'message_en' => 'Email verified successfully',
            'message_ar' => 'تم التحقق من البريد الإلكتروني بنجاح',
        ],200);
    }


    public function sendPasswordResetLinkEmail(Request $request) {
		$request->validate(['email' => 'required|email']);

		$status = Password::sendResetLink(
			$request->only('email')
		);

		if($status === Password::RESET_LINK_SENT) {
			return response()->json(['message_en' => __($status),'message_ar' => 'لقد تواصلنا معك عبر بريدك الالكترونى' ], 200);
		}
        else {
			throw ValidationException::withMessages([
				'message_en' => __($status),
				'message_ar' => 'رجاء الانتظار قبل المحاولة مرة اخرى'
			]);
		}
	}

	public function resetPassword(Request $request) {
		$request->validate([
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|min:8|confirmed',
		]);

		$status = Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function ($user, $password) use ($request) {
				$user->forceFill([
					'password' => Hash::make($password)
				])->setRememberToken(Str::random(60));

				$user->save();

				event(new PasswordReset($user));
			}
		);

		if($status == Password::PASSWORD_RESET) {
			return response()->json(['message' => __($status)], 200);
		} else {
			throw ValidationException::withMessages([
				'email' => __($status)
			]);
		}
	}

    public function get_token(): JsonResponse
    {
        return response()->json(['_gtn_at' => Cookie::get('token')],200);
    }
}
