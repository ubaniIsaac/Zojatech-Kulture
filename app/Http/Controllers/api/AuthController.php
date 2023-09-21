<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Models\{User};
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\{Auth};
use Illuminate\Support\Facades\Hash;
use App\Jobs\{SignUpJobs};
use App\Http\Resources\UserResources;

class AuthController extends Controller
{
    //
    use ResponseTrait;
    public function register(SignUpRequest $request): JsonResponse
    {
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

        $data = [
            'device_id' => $request->device_id,
            'device_name' => $request->device_name,
            'device_os' => $request->device_os,
            'device_ip' => $request->device_ip,
            'referred_by' => $request->referred_by,
        ];


        dispatch(new SignUpJobs($user, $data));

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

        return $this->successResponse('User logged in successfully', [
            'token' => $token,
            'user' => new UserResources($user)
        ]);
    }

    public function signout(Request $request): JsonResponse
    {
        Auth::logout();

        return $this->successResponse('User logged out successfully');
    }
}
