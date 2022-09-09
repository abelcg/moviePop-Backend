<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentsRateController;
use App\Http\Controllers\Api\FavoriteController;
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

Route::controller(FavoriteController::class)->group(function () {
    Route::post('/favorite/{id}', 'store');
    Route::get('/favorite/{id}', 'show');
    Route::delete('/favorite/{id}', 'delete');
    Route::delete('/favorite/{id}', 'destroy');
});

Route::controller(CommentsRateController::class)->group(function () {
    Route::post('/comment/{id}', 'store');
   /*  Route::get('/comment/{id}', 'show');
    Route::delete('/comment/{id}', 'delete');
    Route::delete('/comment/{id}', 'destroy'); */
});
