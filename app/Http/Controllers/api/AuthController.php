<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResources;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SignUpRequest;
use App\Models\{User, Producer, };

class AuthController extends Controller
{
    //

    public function register(SignUpRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create($data);

        if ($data['user_type'] === 'producer') {
         $user  =  Producer::create(['user_id' => $user->id]);
        }

        return response()->json(
            [
                'message' => 'User created successfully',
                'data' => $user
            ],
            201
        );
    }
}
