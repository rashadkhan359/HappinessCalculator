<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\otp_verification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite as Socialite;


class AuthenticationController extends Controller
{
    public function signup(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|numeric|digits:10|unique:users',
                'gender' => 'required|string',
                'age' => 'required|numeric',
                'date_of_birth' => 'required|date',
                'password' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 400);
        }

        $otp = mt_rand(100000, 999999);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = 2;
        $user->gender = $request->gender;
        $user->age = $request->age;
        $user->phone = $request->phone;
        $user->date_of_birth = $request->date_of_birth;
        $user->status = 1;
        $user->save();
        $user->otp()->create([
            'user_id' => $user->id,
            'otp' => $otp,
            'otp_verification_status' => 0,
            'otp_expire_time' => date('Y-m-d H:i:s', strtotime("+15 min")),
            'otp_type' => 0,
        ]);

        $data = ['name' => $request->name, 'otp' => $otp];
        $user['to'] = $request->email;
        Mail::send('mail', $data, function ($messages) use ($user) {
            $messages->to($user['to']);
            $messages->subject("OTP for User Registration");
        });
        return response()->json([
            'status' => 'OTP sent successfully',
        ], 200);
    }

    public function otpVerification(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|string|email|max:255',
                'otp' => 'required|numeric|digits:6',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 400);
        }
        $user = User::where('email', $request->email)->first();
        $otp = $user->otp()->where('otp', $request->otp)->first();
        if ($otp) {
            if ($otp->otp_verification_status == 0) {
                if ($otp->otp_expire_time > date('Y-m-d H:i:s')) {
                    $otp->otp_verification_status = 1;
                    $otp->save();
                    return response()->json([
                        'status' => 'OTP verified successfully',
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'OTP expired',
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => 'OTP already verified',
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 'Invalid OTP',
            ], 400);
        }
    }

    public function otpResend(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|string|email|max:255',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 400);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'No such user exist',
            ], 400);
        }
        $otp = $user->otp()->where('otp_type', 0)->first();
        if ($otp) {
            if ($otp->otp_verification_status == 0) {
                if ($otp->otp_expire_time > date('Y-m-d H:i:s')) {
                    $otp->otp = mt_rand(100000, 999999);
                    $otp->otp_expire_time = date('Y-m-d H:i:s', strtotime("+15 min"));
                    $otp->save();
                    $data = ['name' => $user->name, 'otp' => $otp->otp];
                    $user['to'] = $request->email;
                    Mail::send('mail', $data, function ($messages) use ($user) {
                        $messages->to($user['to']);
                        $messages->subject("OTP for User Registration");
                    });
                    return response()->json([
                        'status' => 'OTP sent successfully',
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'OTP expired',
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => 'OTP already verified',
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 'Invalid OTP',
            ], 400);
        }
    }
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|string|max:50',
                'password' => 'required|string|min:6',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 400);
        }
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password',
            ], 401);
        }

        $user = Auth::user();
        $id = otp_verification::where('user_id', $user->id)->first();
        if ($id->otp_verification_status == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorised access.',
            ], 401);
        }


        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token,
        ], 200);
    }
    public function forgotPassword(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'email' => 'required|string|email|max:255',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 400);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'No such user exist',
            ], 400);
        }
        $otp = mt_rand(100000, 999999);
        $user->otp()->create([
            'user_id' => $user->id,
            'otp' => $otp,
            'otp_verification_status' => 0,
            'otp_expire_time' => date('Y-m-d H:i:s', strtotime("+15 min")),
            'otp_type' => 1,
        ]);

        $data = ['name' => $request->name, 'otp' => $otp];
        $user['to'] = $request->email;
        Mail::send('mail', $data, function ($messages) use ($user) {
            $messages->to($user['to']);
            $messages->subject("OTP for Forgot Password");
        });
        return response()->json([
            'status' => 'OTP sent successfully',
        ], 200);
    }


    public function resetpassword(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 400);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'No such user exist',
            ], 400);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'status' => 'Password Reset Successfully',
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ], 200);
    }

    public function redirectToProvider($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }
    public function handleProviderCallback($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        //this code is used for when app developer is sent token to backend and backend verify that token with help this url
        //and refer the machinerental googlelogin code for more

        // $url = "https://oauth2.googleapis.com/tokeninfo";
        // $response = Http::get($url, [
        //     'id_token' => $request->code,
        // ]);

        // if (!$response->ok()) {
        //     return response()->json([
        //         "response_code" => 402,
        //         "response_message" => "Invalid Access Token"
        //     ], 402);
        // }
        // else{
        $data = $user->attributes;
        $providerId = $data['id'];
        $name = $data['name'];
        $email = $data['email'];
        $profile_pic = $data['avatar_original'];
        //check if email already exists
        $checkIfUserExists = User::where('email', $email)->first();
        if (!$checkIfUserExists) {
            //dont have this user so we create new one
            $newuser =  User::create([
                'name' => $name,
                'email' => $email,
                'password' => \Str::random(8),
                'profile_pic' => $profile_pic,
                'email_verified_at' => time(),
                'provider_id' => $providerId,
                'provider' => $provider,
                'role_id' => 2,
                'status' => true
            ]);
        } else {
            //user already exists
            $socialAccount = $checkIfUserExists->where('provider_id', $providerId)->first();
            //if social account is not linked to this email, then link it
            if (!$socialAccount) {
                $checkIfUserExists->update([
                    'provider_id' => $data['id'],
                    'provider' => $provider,
                ]);
            }
            $newuser = $checkIfUserExists;
        }

        //}
        return response()->json([
            'user' => $newuser,
            'token' => $user->token,
        ], 200);
    }

    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['facebook', 'google'])) {
            return response()->json(['error' => 'Please login using facebook or google'], 422);
        }
    }
}
