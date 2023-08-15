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
         return $this->okResponse('Genres retrieved successfully', GenreResources::collection($genres));
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

            return $this->okResponse('Genre created successfully', new GenreResources($Genre));
        } catch (\Throwable $th) {

            return $this->errorResponse('Genre not created');
        }
    }

    public function update(Request $request, $id)
    {
       try {
            $genre = Genre::findOrFail($id);
            $genre->update($request->all());
            return $this->okResponse('Genre updated successfully', new GenreResources($genre));
       } catch (\Throwable $th) {
            return $this->errorResponse('Genre not updated');
       }
    }


    public function destroy($id)
    {
        try {
            $genre = Genre::findOrFail($id);
            $genre->delete();
            return $this->okResponse('Genre deleted successfully', new GenreResources($genre));
        } catch (\Throwable $th) {
            return $this->errorResponse('Genre not deleted');
        }
    }
}
