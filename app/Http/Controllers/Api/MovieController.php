<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{

    public function index()
    {
        $movie = Movie::all();
        return response()->json([
            'status' => 200,
            'movie' => $movie,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:70|min:5',
            'language' => 'required|max:10',
            'genres' => 'required|max:10',
            'releaseDate' => 'required|max:10',
            'synopsis' => 'required|max:300|min:10',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validate_error' => $validator->messages(),
            ]);
        } else {
            $movie = new Movie();
            $movie->title = $request->input('title');
            $movie->language = $request->input('language');
            $movie->genres = $request->input('genres');
            $movie->releaseDate = $request->input('releaseDate');
            $movie->synopsis = $request->input('synopsis');
            $movie->save();

            return response()->json([
                'status' => 200,
                'message' => 'Película agregada correctamente'
            ]);
        }
    }

    public function show($id)
    {
        $movie = Movie::find($id);
        if ($movie) {
            return response()->json([
                'status' => 200,
                'movie' => $movie,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No se encontró la película buscada'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:70|min:5',
            'language' => 'required|max:10',
            'genres' => 'required|max:10',
            'releaseDate' => 'required|max:10',
            'synopsis' => 'required|max:300|min:10',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $movie = Movie::find($id);
            if ($movie) {
                $movie->title = $request->input('title');
                $movie->language = $request->input('language');
                $movie->genres = $request->input('genres');
                $movie->releaseDate = $request->input('releaseDate');
                $movie->synopsis = $request->input('synopsis');
                $movie->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Se modifico la película correctamente'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No se encontró la película buscada'
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $movie = Movie::find($id);
        if ($movie) {
            $movie->delete();
            return response()->json([
                'status' => 200,
                'message' => 'La película fue eliminada correctamente'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No se encontró la película buscada'
            ]);
        }
    }
}
