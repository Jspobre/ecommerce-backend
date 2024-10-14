<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Pokemon\PokemonGenerationScraperController;
use  App\Http\Controllers\testController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pokemon-generation', PokemonGenerationScraperController::class);

Route::get('/fetch-pokemon', [testController::class, 'fetchData']);

Route::get('/all-users', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::get('/profile/{user_id}', [UserController::class, 'profile'])->middleware('auth:sanctum');;
Route::post('/login', [UserController::class, 'login']);
Route::post('/signin', [UserController::class, 'signIn']);

// Route::post('/login', [UserController::class, 'login']);
// Route::put('/update-user/{user_id}', [UserController::class, 'updateUser']);
// Route::delete('/delete-user/{user_id}', [UserController::class, 'deleteUser']);