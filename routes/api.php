<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::put('/isAdmin/{id}', 'isAdmin');
    Route::get('/users', 'index');
});

 Route::middleware('jwt.verify')->group(function (){
    Route::post('/isUserAuth', [AuthController::class,  'adminBoard']);
}); 
 

Route::controller(MovieController::class)->group(function () {
    Route::get('/movies', 'index');
    Route::post('/movie', 'store');
    Route::get('/movie/{id}', 'show');
    Route::put('/movie/{id}', 'update');
    Route::delete('/movie/{id}', 'destroy');
});
