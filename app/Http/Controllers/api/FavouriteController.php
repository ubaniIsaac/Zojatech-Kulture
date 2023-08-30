<?php

namespace App\Http\Controllers\api;

use App\Models\Beat;
use App\Models\User;
use App\Models\Artiste;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\FavouriteResource;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $id)
    {
        $auth = auth()->id();
        $user = User::find($auth);
        $favourites = $user->favourites;
         
        return response()->json([
            'message' => 'favourites displayed successfully',
            'favourites' => FavouriteResource::collection($favourites)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        try {
            $auth = auth()->id();
            $user = User::find($auth);
            $beat = Beat::find($id);

            $favourited = $user->favourites->contains($beat->id);

            if($favourited) {
                return response()->json([
                    'message' => 'beat already exists in favourites'
                ], 200);
            }
                $user->favourites()->attach($beat->id);
                return response()->json([
                    'message' => 'beat added to favourites'
                ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'error adding beat to favourites'
            ], 403);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete(Request $request, string $id): JsonResponse
    {
       
        try {
            $auth = auth()->id();
            $user = User::find($auth);
            $beat = Beat::find($id);
            
            $isExist = $user->favourites->contains($beat->id);

            if($isExist) {
             $user->favourites()->detach($beat->id);

            }
                return response()->json([
                    'message' => 'Beat removed from favorites.'
                ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'error occurred while removing beat from favourites.'
            ], 200);
        }
    }
}
