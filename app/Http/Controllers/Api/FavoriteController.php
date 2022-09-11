<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class FavoriteController extends Controller
{
    /* agrega las peliculas favoritas del usuario */

    public function store(Request $request, $id)
    {
        $user = User::find($id);
        $user->movies()->attach($request->movieId);

        return response()->json([
            'status' => 200,
            'message' => 'Película agregada a favoritos correctamente'
        ]);
    }

    /* muestra el usuario con sus películas favoritas */

    public function show($id)
    {
        $user = User::with('movies')->find($id);
        if ($user) {
            return response()->json([
                'status' => 200,
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No se encontró el usuario buscado'
            ]);
        }
    }

    /* eliminar solo una película de favoritos */
    public function delete(Request $request, $id)
    {
        $user = User::find($id);
        $user->movies()->detach($request->movieId);

        return response()->json([
            'status' => 200,
            'message' => 'Película eliminada de favoritos correctamente',
        ]);
    }
}
