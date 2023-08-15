<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Producer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResources;

class UserController extends Controller
{
    public function index(Request $request)
     {
        // $perPage = $request->query('per_page', 10);

        // $users = U   ser::paginate($perPage);

        $users = User::latest()->paginate(10)->through(fn ($user) => new UserResources($user));

        return response()->json([
            'message' => 'Users listed successfully',
            'data' => $users
        ]);
    } 

    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);

            // dd($user);

            return response()->json([
                'message' => 'User retrieved succcessfully',
                'data' => new UserResources($user)
            ], 200);

        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'user not found',
            ], 404);
        }
    }

    public function update(Request $request, string $user): JsonResponse
    {
        try {
            //code...
            $user = User::findOrFail($user);

            $user->update($request->except('profile_picture'));

            if ($request->hasFile('profile_picture')) {
                $user->clearMediaCollection('avatars');
                $user->addMediaFromRequest('profile_picture')->toMediaCollection('avatars');
                $user->save();
            };
            return response()->json([
                'Message' => 'User updated successfully',
                'data' => new UserResources($user),
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'Message' => 'User not found',

            ], 404);
        }
    }

    public function destroy(string $user): JsonResponse
    {
        try {
            //code...
            $user = User::findOrFail($user);
            $user->delete();

            return response()->json([
                'message' => "user delete successfully",
                'data' => new UserResources($user),
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => "user was not found ",
            ], 404);
        }
    }


    public function getProducers() 
    {
        
        $user = User::with('producers')->whereHas("roles", function($q){ $q->where('name', 'producer'); })->get();

        return response()->json([
            'message' => 'producers listed successfully',
            'data' => $user
        ], 200);
    }

    public function getArtistes() 
    {
        
        $user = User::with('artistes')->whereHas('roles', function($q){ $q->where('name', 'artiste'); })->get();

        return response()->json([
            'message' => 'artistes listed successfully',
            'data' => new UserResources($user)
        ], 200);
    }
}
