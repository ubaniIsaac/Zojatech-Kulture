<?php

namespace App\Http\Controllers\Api;

use App\Models\Beat;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Models\{Artiste, User};
use Illuminate\Http\JsonResponse;


use App\Http\Controllers\Controller;
use App\Http\Resources\{ArtisteResource};

class ArtisteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ResponseTrait;
    public function index(Request $request): JsonResponse
    {
        try {
            $artistes = Artiste::latest()->paginate(10)->through(fn ($artistes) => new ArtisteResource($artistes));

            return $this->successResponse('Artistes retrieved successfully', $artistes);
        } catch (\Throwable $th) {
            return $this->errorResponse('Artistes not found');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            if(!$user) {
                return $this->errorResponse('User not found');
            }

            $artiste = Artiste::where('user_id', $user->id)->first();

            if(!$artiste) {
                return $this->errorResponse('User is not an Artiste');
            }

            // Update the artiste's view count
            $artiste->increment('profile_views');

            return $this->successResponse('Artiste retrieved successfully', new ArtisteResource($artiste));
        } catch (\Throwable $th) {
            return response()->json(['exception' => $th->getMessage()]);
            // return $this->errorResponse('User not found');
        }
    }

}
