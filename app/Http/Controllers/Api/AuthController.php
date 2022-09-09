<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|min:8',
            'passwordCheck' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages(),
            ]);
        }
        /* Eloquent creation of data */
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Usuario creado correctamente'
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages(),
            ]);
        }
        $credentials = $request->only('email', 'password');
        $email = $request->input('email');
        $user = User::where('email', $email)->first();;
        if (!$user) {
            return response()->json([
                'status' => 400,
                'message' => 'No existe usuario registrado con este email'
            ]);
        }
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciales invalidas'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Autentificación exitosa',
            'accessToken' => $token,
            'user' => $user,
        ]);
    }

    /* Función para asignar rol de usuario admin */
    public function isAdmin(Request $request, $id)
    {
        $user = User::find($id);
        if($user) {
            $user->isAdmin = $request->input('isAdmin');
            $user->update();

            return response()->json([
                'status' => 200,
                'message' => 'El rol del usuario fue modificado'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Error al buscar al usuario solicitado'
            ]);
        }
    }

    /* obtener la lista de usuarios */

    public function index()
    {
        $user = User::all();
        return response()->json([
            'status' => 200,
            'user' => $user,
        ]);
    }

    //Para autorizar usuario admin
    public function adminBoard()
    {
        return response()->json([
            'status' => 200,
            'auth' => true,
            'message' => 'Contenido de Admnin'
        ]);
    }
    
}
