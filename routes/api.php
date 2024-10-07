<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/', function(Request $request){
   return response()->json([
    'Code' => 200,
    'Message' => 'Success Bitch'
   ]);
});


Route::get('/all-users', [UserController::class, 'index']);
Route::get('/fetch-user/{user_id}', [UserController::class, 'fetchUser']);
Route::post('/insert', [UserController::class, 'insertData']);

Route::post('/login', [UserController::class, 'login']);
Route::put('/update-user/{user_id}', [UserController::class, 'updateUser']);
Route::delete('/delete-user/{user_id}', [UserController::class, 'deleteUser']);