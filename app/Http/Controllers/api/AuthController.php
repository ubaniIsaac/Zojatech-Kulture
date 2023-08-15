<?php

namespace App\Http\Controllers\api;

use App\Models\Artiste;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\{User, Producer, };
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResources;

class AuthController extends Controller
{
    //
    use ResponseTrait;
    public function register(SignUpRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create($data);

        if ($data['user_type'] === 'producer') {
            $producer  =  Producer::create(['user_id' => $user->id]);
            $producer->assignRole('producer');

        } elseif ($data['user_type'] === 'artiste') {
            $artiste  =  Artiste::create(['user_id' => $user->id]);
            $artiste->assignRole('artiste');

        }
        
        return $this->successResponse('User created successfully', [
            'user' => new UserResources($user)
        ]);
    }
    
    public function signin(LoginRequest $request): JsonResponse
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $token = $user->createToken("$user->name token")->accessToken;

        return $this->successResponse('User logged in successfully', [
            'token' => $token,
            'user' => new UserResources($user)
        ]);
    }

    public function signout(Request $request)
    {
        Auth::logout();

        return $this->successResponse('User logged out successfully');
        
    }
}
