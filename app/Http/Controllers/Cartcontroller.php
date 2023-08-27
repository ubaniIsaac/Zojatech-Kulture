<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cartrequest;
use App\Http\Resources\CartResource;
use App\Models\Beat;
use App\Models\Cart;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class Cartcontroller extends Controller
{
    //
    public function create(CartRequest $request):JsonResponse
    {
        $beat = Beat::findOrFail($request->beat_id);
        $quantity = $request->quantity; 

        //Retrieve the cart from the session 
        $cart = session()->get('cart',[]);

        //Add the beat Id to the cart array
        $cart[] =$beat->id;

        //Store the updated cart array in the session
        session(['cart'=>$cart]);

         return response()->json([
            'message' => 'Beat added successfully',
            'data' => new CartResource($cart) 
        ], 201);

    }
    public function destroy($beatId):JsonResponse
    {
       // Find the beat
       $beatId = Beat::findOrFail($beatId);


       // Delete the beat
       $beatId->delete();

       return response()->json(['message' => 'Beat deleted successfully'], 200);
    }

    public function index(Request $request):JsonResponse
    {
        // Get the cart items for the current user
        $cartItems = Cart::content();

        return response()->json(['message' => 'All beats in the cart viewed successfully'], 200);

    }
}

