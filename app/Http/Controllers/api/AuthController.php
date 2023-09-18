<?php

namespace App\Http\Controllers\api;

use App\Models\Artiste;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
// use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResources;
use App\Models\{Cart, User, Producer };




class AuthController extends Controller
{
    //
    use ResponseTrait;
    public function register(SignUpRequest $request): JsonResponse
    {
        $data = $request->all();

        if ($request->hasFile('profile_picture')) {
            $imageUrl = MediaService::uploadImage($request->file('profile_picture'), 'profileImages');
        }

        $user = User::create(array_merge(
            $request->validated(),
            [
                'username' => $request->username,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'profile_picture' => $imageUrl ?? '',
                'user_type' => $request->user_type,
                'password' => $request->password,
                'confirm_password' => $request->confirm_password,
            ]
        ));

        if ($data['user_type'] === 'producer') {
            $user->producers()->create(['user_id' => $user->id]);
        } elseif ($data['user_type'] === 'artiste') {
            $user->artistes()->create(['user_id' => $user->id]);
            Cart::create(['user_id' => $user->id, 'items' => []]);

        }
       
        return $this->successResponse('User created successfully', [
            'user' => new UserResources($user)
        ], 201);
    }
    
    public function signin(LoginRequest $request): JsonResponse
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $token = $user->generateToken();
        $token = $user->createToken($user->email, [$user->user_type])->accessToken;

        $userAgent = $request->header('User-Agent');
        $userIP = $request->ip();
        Log::info('User agent details: ' . $userAgent);
        Log::info('User IP: ' . $userIP);


        return $this->successResponse('User logged in successfully', [
            'token' => $token,
            'user' => new UserResources($user)
        ]);
    }


    // public function forgetPassword(ForgotPasswordRequest $request)
    // {
    //     // Delete all old codes that the user sent before.
    //     ResetCodePassword::where('email', $request->email)->delete();

    //     // Generate random code
    //     $data['email'] = $request->email;
    //     $data['Token'] = rand(100, 999); // Updated range for 3-digit numbers
    //     $data['created'] = now();

    //     $code = ResetCodePassword::create($data);

    //     return response(['message' => trans('passwords.sent')], 200);
    // }

    // public function passwordReset(PasswordResetRequest $request)
    // {
    //     $user = User::where('email', $request->email)->first();

    //     if (!$user) {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }

    //     // Validate the password using Laravel's validation rules.
    //     $validatedData = $request->validate([
    //         'password' => ['required', 'string', 'min:8'], // Add your desired validation rules
    //     ]);

    //     $user->fill([
    //         'password' => Hash::make($validatedData['password']),
    //     ]);
    //     $user->save();

    //     DB::table('resetcodepassword')
    //         ->where('email', $user->email)
    //         ->delete();

    //     return response()->json([
    //         'message' => 'Password reset successful',
    //         'data' => [$user],
    //     ]);
    // }


    public function signout(Request $request): JsonResponse
    {
        Auth::logout();

        return $this->successResponse('User logged out successfully');
        
    }
}
