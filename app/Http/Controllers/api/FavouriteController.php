<?php

namespace App\Http\Controllers\api;

use App\Models\Artiste;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $id)
    {
        $auth = auth()->id();
        $artiste = Artiste::find($auth);
        $cart = $artiste->cart;
         
        return response()->json([
            'message' => 'beat carts displayed successfully',
            'cart' => CartResource::collection($cart)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
