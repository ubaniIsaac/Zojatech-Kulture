<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;    
use App\Models\Beat;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth()->user();
        $beatId = $request->route('id');
        
        $beat = Beat::find($beatId);
    
        if (!$beat) {
            return response()->json([
                'message' => 'Beat not found'
            ], 404);
        }
    
        if ($user && $user->id === $beat->user_id) {
            return $next($request);
        } else {
            return response()->json([
                'message' => 'You are not authorized to perform this action'
            ], 403);
        }
    }
    
}
