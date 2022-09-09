<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CommentsRateController extends Controller
{
    /* agrega comentarios a las peliculas*/

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comentario' => 'required|max:150|min:5',
            'calificacion' => 'required|integer|between:1,5',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $user = User::find($id);
            $user->comments()->attach($request->movieId);
        }
    }
}
