<?php

namespace App\Http\Controllers\api;

use App\Models\Beat;
use App\Http\Controllers\Controller;
use App\Models\{Genre, Producer};
use Illuminate\Http\Request;
use App\Http\Resources\BeatResources;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Services\MediaService;

use App\Http\Requests\{UploadBeatRequest};

class BeatController extends Controller
{
    //
    use ResponseTrait;
    public function index(): JsonResponse
    {
        //
        $beats = Beat::all();
        return $this->successResponse('Beats retrieved successfully', BeatResources::collection($beats));
    }


    public function upload(UploadBeatRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $user = Auth()->user();

            if (!$user) {
                return $this->errorResponse('User not found');
            }

            $userId = $user->id;

            $producer = Producer::where('user_id', $userId)->first();

            if (!$producer) {
                return $this->errorResponse('User is not a producer');
            }

            $genre = Genre::where('name', $data['genre'])->first();

            if (!$genre) {
                return $this->errorResponse('Genre not found');
            }
            $genreId = $genre->id;

            if ($request->hasFile('image')) {
                $imageUrl = MediaService::uploadImage($request->file('image'), 'beatsImages');
            }

            if ($request->hasFile('audio')) {
                $audioUrl = MediaService::uploadAudio($request->file('audio'), 'beatsAudios');
            }

            $beat = Beat::create(array_merge(
                $request->validated(),
                [
                    'duration' => '00:51',
                    'size' => $data['audio']->getSize(),
                    'type' => $data['audio']->getMimeType(),
                    'imageUrl' => $imageUrl,
                    'fileUrl' => $audioUrl,
                    'user_id' => $userId,
                    'producer_id' => $producer->id,
                    'genre_id' => $genreId
                ]
            ));

            //update producer beats count
            $producer->increment('total_beats');

            return $this->successResponse('Beat uploaded successfully', new BeatResources($beat), 201);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $beat = Beat::find($id);

            if (!$beat) {
                return $this->errorResponse('Beat not found');
            }
            $beat->increment('view_count');


            return $this->successResponse('Beat retrieved successfully', new BeatResources($beat));
        } catch (\Throwable $th) {
            return $this->errorResponse('Beat not found');
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $beat = Beat::findOrFail($id);


            $beat->update($request->all());
            return $this->successResponse('Beat updated successfully', new BeatResources($beat));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $beat = Beat::findOrFail($id);
            $beat->delete();
            return $this->successResponse('Beat deleted successfully', new BeatResources($beat));
        } catch (\Throwable $th) {
            return $this->errorResponse('Beat not deleted');
        }
    }
}
