<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Producer;
use Illuminate\Http\Request;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResources;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserController extends Controller
{
    use ResponseTrait;

    public function index(Request $request): JsonResponse
     {
        $users = User::latest()->paginate(10)->through(fn ($user) => new UserResources($user));

        return $this->successResponse('Users listed successfully', [
            'data' => $users
        ]);
    } 

    public function show(string $id): JsonREsponse
    {
        try {
            $user = User::findOrFail($id);

            // dd($user);

            return $this->successResponse('User retrieved succcessfully', [
                'data' => new UserResources($user)
            ]);

        } catch (\Throwable $th) {

            return $this->errorResponse('user not found', 404);
        }
    }

    public function update(Request $request, string $user): JsonResponse
    {
        try {
            //code...
            $user = User::findOrFail($user);

            $data = $request->except('profile_picture');
            $user->update($data);

            // dd($user);

            if ($request->hasFile('profile_picture')) {
                if ($user->profile_picture) {
                    Cloudinary::destroy($user->profile_picture);
                }
                $imageUrl = MediaService::uploadImage($request->file('profile_picture'), 'profileImages');
                // $profile_picture = cloudinary()->upload($request->file('profile_picture')->getRealPath())->getSecurePath();
            };

            $user->update([
                'profile_picture' => $imageUrl, // Update the Cloudinary URL
            ]);

            // $user->update(array_merge($request->all(),['profile_picture' => $imageUrl]));
            dd($user);

    
            // dd($user);
            return $this->successResponse('User updated successfully', [
                'data' => new UserResources($user)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            // return $this->errorResponse('User not found', 404);
            return response()->json([
                'message' => "user was not found ",
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


//     public function getProducers() 
//     {
        
//         $user = User::with('producers')->whereHas("roles", function($q){ $q->where('name', 'producer'); })->get();

//         return response()->json([
//             'message' => 'producers listed successfully',
//             'data' => $user
//         ], 200);
//     }

}
