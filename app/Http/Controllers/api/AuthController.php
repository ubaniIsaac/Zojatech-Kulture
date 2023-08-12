<?php

namespace App\Http\Controllers\api;

use App\Models\Artiste;
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
        
        return response()->json(
            [
                'message' => 'User created successfully',
                'data' => $user
            ],
            201
        );
    }
    
    public function signin(LoginRequest $request): JsonResponse
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 200);
        }

        $token = $user->createToken("$user->name token")->accessToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'data' => $user,
            'token' => $token
        ]);
    }

    public function signout(Request $request)
    {
        Auth::logout();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
        
    }
}
