<?php

namespace App\Http\Controllers\api;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlagBeatRequest;
use Illuminate\Http\Request;

class FlagController extends Controller
{
    use ResponseTrait;
    public function index(): JsonResponse
    {
        $flags = Flag::all();
        return $this->successResponse('All Flags retrieved successfully', GenreResources::collection($genres));
    }

    public function store(request $FlagBeatRequest): JsonResponse
    {
     
        
    }
}
