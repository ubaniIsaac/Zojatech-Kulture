<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SignUpRequest;
use App\Models\User;

class AuthController extends Controller
{
    //

    public function register(SignUpRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create($data);

        return response()->json(
            [
                'message' => 'User created successfully',
                'data' => $user
            ],
            201
        );
    }
}
