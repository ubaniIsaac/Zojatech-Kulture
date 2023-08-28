<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cartrequest;
use App\Http\Resources\CartResource;
use App\Models\Beat;
use App\Models\Cart;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class Cartcontroller extends Controller
{
    //
    public function add(Request $request): JsonResponse
    {
        $beat = Beat::findOrFail($request->beat_id);
        $cart = Cart::where('user_id', auth()->user()->id)->first();
        $items = json_decode($cart->items);

        if  (in_array($beat->id, $items)) {
            return response()->json([
                'message' => 'Beat already exists',
                'data' => new CartResource($cart)
            ], 
        );
        }
        $items = array_merge($items, [$beat->id]);
        $total_price = $cart->total_price += $beat->price;


        $cart->update(['items' => json_encode($items), 'total_price' => $total_price]);

        return response()->json([
            'message' => 'Beat added successfully',
            'data' => new CartResource($cart)
        ], 201);

    }
    public function destroy(Request $request): JsonResponse
    {
        // Find the beat
        $beat = Beat::findOrFail($request->beat_id);
        $cart = Cart::where('user_id', auth()->user()->id)->first();
        $items = json_decode($cart->items);

        // Delete the beat
        $items = array_diff($items, [$beat->id]);

        $cart->update(['items' => json_encode($items)]);

        return response()->json(['message' => 'Beat deleted successfully'], 200);
    }

    public function view(Request $request): JsonResponse
    {
        $cart = Cart::where('user_id', auth()->user()->id)->first();
        $items = json_decode($cart->items);
        // Get the cart items for the current user
        $cart = json_decode($cart->items);

        return response()->json(['message' => 'All beats in the cart viewed successfully'], 200);

    }
}