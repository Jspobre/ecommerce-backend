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
    'Message' => 'Success'
   ]);
});

Route::middleware(['auth:sanctum', 'ability:insert-user,update-user,delete-user'],)->group(function(){
  Route::post('/admin/insert-user', [UserController::class, 'insertUser']);
  Route::post('/admin/login', [UserController::class, 'AdminLogin']);
});

Route::get('/all-users', [UserController::class, 'index']);
Route::get('/fetch-user/{user_id}', [UserController::class, 'fetchUser']);
Route::post('/insert', [UserController::class, 'insertData']);


Route::post('/login', [UserController::class, 'login']);
Route::put('/update-user/{user_id}', [UserController::class, 'updateUser']);
Route::delete('/delete-user/{user_id}', [UserController::class, 'deleteUser']);
Route::post('/logout', [UserController::class, 'logout'])-> middleware('auth:sanctum');