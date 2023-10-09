<?php

namespace App\Http\Controllers\api;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlagBeatRequest;
use Illuminate\Http\Request;
use App\Http\Resources\FlagResources;
use App\Models\Beat;
use App\Models\Flag;
use Illuminate\Http\JsonResponse;

class FlagController extends Controller
{
    use ResponseTrait;
    public function index(): JsonResponse
    {
        $flags = Flag::all();
        return $this->successResponse('All Flags retrieved successfully', FlagResources::collection($flags));
    }

    public function flagBeat(FlagBeatRequest $request): JsonResponse
    {
       try {
        $request = $request->validated();

        $beat = Beat::find($request['beat_id']);

        if(!$beat){
            return $this->notFoundResponse('Beat not found');
        }


        dd(auth()->user()->id);

        $flag = Flag::create([
            'beat_id' => $request['beat_id'],
            'user_id' => auth()->user()->id,
            'producer_id' => $beat->producer_id,
            'reason' => $request['reason'],
            'description' => $request['description'],
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

       }catch (\Exception $e){
           return $this->okResponse($e->getMessage());
       }        
    }
}
