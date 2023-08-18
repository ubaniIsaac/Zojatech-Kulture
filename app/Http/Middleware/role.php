<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Beat;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth()->user();


        //Check if user is a producer
        if ($user &&  $user->user_type === 'producer') {
            return $next($request);
        } else {
            return response()->json([
                'message' => 'You are not authorized to perform this action'
            ], 403);
        }
    }
}
