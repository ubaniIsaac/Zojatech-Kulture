<?php

namespace App\Http\Controllers\api;
use App\Traits\ResponseTrait;
use App\Models\Genre;
use App\Http\Requests\CreateGenreRequest;
use App\Http\Resources\GenreResources;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    //
    use ResponseTrait;
    public function index()
    {
       $genres = Genre::all();
         return response()->json([
            'message' => 'Genres retrieved successfully',
            'data' => GenreResources::collection($genres)
         ]);
    }

    public function show($id)
    {
        try {
            $genre = Genre::findOrFail($id);
            return $this->okResponse('Genre retrieved successfully', new GenreResources($genre));

        } catch (\Throwable $th) {
            return $this->errorResponse('Genre not retrieved');
        }
    }

    public function store(CreateGenreRequest $request)
    {
        try {
            
            $Genre = Genre::create($request->validated());

            return response()->json([
                'message' => "Genre Created successfully",
                'data' => new GenreResources($Genre)
            ], 201);
        } catch (\Throwable $th) {

            return $this->errorResponse('Genre not created');
        }
    }

    public function update(Request $request, $id)
    {
       try {
            $genre = Genre::findOrFail($id);
            $genre->update($request->all());
            return response()->json([
                'message' => "Genre updated successfully",
                'data' => new GenreResources($genre)
            ], 200);
       } catch (\Throwable $th) {
            return $this->errorResponse('Genre not updated');
       }
    }


    public function destroy($id)
    {
        try {
            $genre = Genre::findOrFail($id);
            $genre->delete();
            return response()->json([
                'message' => "Genre deleted successfully",
                'data' => new GenreResources($genre)
            ], 200);
        } catch (\Throwable $th) {
            return $this->errorResponse('Genre not deleted');
        }
    }
}
