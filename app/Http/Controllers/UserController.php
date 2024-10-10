<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    

  public function index() {
    return User::all();
  }


  public function insertData(Request $request){
 
    try {

      $validateData = $request->validate([
          'first_name' => 'required|string|max:255',
          'last_name' => 'required|string|max:255',
          'email' => 'required|string|unique:users|max:255',
          'password' => 'required|min:8'
      ]);

      $user = User::create([
        'first_name' => $validateData['first_name'],
        'last_name' => $validateData['last_name'],
        'email' => $validateData['email'],
        'password' => Hash::make($validateData['password'])
     ]);

     return response()->json([
      'Code' => 200,
      'Message' => 'Success',
      'Data' => $user
     ]);
    } catch (\Throwable $th) {
      return response()->json([
        'error' => $th
      ]); 
    }
     
  }

  public function login(Request $request){

    try {
      $validateData = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
      ]);

      if(Auth::attempt($validateData, true)){

        $user = Auth::user();

        $token = $request->user()->createToken('my_token')->plainTextToken;
        
        return response()->json([
          'Code' => 200,
          'Message' => 'User authenticated!',
          'User ID' => $user,
          'Token' => $token
        ]);
      } else{
        return response()->json([
            'Code' => 404,
            'Message' => 'User not found! Please try again',
        ]);
      }
    } catch (\Throwable $th) {
      return response()->json([
        'error' => $th->getMessage()
      ]); 
    }
  }

  public function updateUser(Request $request, String $user_id){

    try {
      $validateData = $request->validate([
        'user_id' => 'nullable',
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['sometimes', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users', 'max:255'],
        'password' => 'nullable'
      ]);

      if(!$user = User::find($validateData['user_id'] || $user_id)){
        return response()->json([
          'Code' => 404,
          'Message' => 'User not found!'
        ]); 
      } 

        $user->first_name = $validateData['first_name'];
        $user->last_name = $validateData['last_name'];
        $user->email = $validateData['email'];
        $validateData['password'] ? $user->password =  Hash::make($validateData['password']) : null;
 
        $user->save();

       return response()->json([
        'Code' => 200,
        'Message' => 'User updated successfully',
        'User' => $user
       ]);

    } catch (\Throwable $th) {
      return response()->json([
        'error' => $th->getMessage()
      ]); 
    }
  }


  public function deleteUser(Request $request, String $user_id){

    try {
      if(!$user = User::find($user_id)){
        return response()->json([
          'Code' => 404,
          'Message' => 'User not found, please try again'
        ]);
    };

    $user->delete();

    return response()->json([
      'Code' => 200,
      'Message' => 'User deleted successfully'
    ]);
    } catch (\Throwable $th) {
        return $th->getMessage();
    }
  }

  public function fetchUser(string $user_id){


    if(!$user = User::find($user_id)){
        return response()->json([
          'Code' => 404,
          'Message' => 'User not found!'
        ]);
    };

    return response()->json([
      'Code' => 200,
      'Message' => 'User found',
      'Data' => $user
    ]);


  }


  public function logout(Request $request){

    // $validateData = $request->validate([
    //   'email' => 'required',
    //   'password' => 'required'
    // ]);

    // if(!Auth::attempt($validateData)){
    //   return response()->json([
    //     'Code' => 404,
    //     'Message' => 'User not found'
    //   ]);

    // }

    $user = Auth::user();
    if(!$user){
        return response()->json([
          'Message' => 'Not a user'
        ]);
    }

    $token = $user->currentAccessToken()->delete();

    return response()->json([
      'Code' => 200,
      'Message' => 'Logout Successfully',
      'Token' => $token ? "Token revoked" : "Token not revoked"
    ]);

  }


  public function insertUser(Request $request){
 
    try {

      $validateData = $request->validate([
          'first_name' => 'required|string|max:255',
          'last_name' => 'required|string|max:255',
          'email' => 'required|string|unique:users|max:255',
          'password' => 'required|min:8'
      ]);

      $user = User::create([
        'first_name' => $validateData['first_name'],
        'last_name' => $validateData['last_name'],
        'email' => $validateData['email'],
        'password' => Hash::make($validateData['password'])
     ]);

     return response()->json([
      'Code' => 200,
      'Message' => 'Success',
      'Data' => $user
     ]);
    } catch (\Throwable $th) {
      return response()->json([
        'error' => $th
      ]); 
    }
     
  }


  public function adminLogin(Request $request){

    try {
      $validateData = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
      ]);

      if(Auth::attempt($validateData, true)){

        $user = Auth::user();

        $token = $request->user()->createToken('my_token', ['get-users,insert-user,update-user,delete-user'])->plainTextToken;
        
        return response()->json([
          'Code' => 200,
          'Message' => 'User authenticated!',
          'User ID' => $user,
          'Token' => $token
        ]);
      } else{
        return response()->json([
            'Code' => 404,
            'Message' => 'User not found! Please try again',
        ]);
      }
    } catch (\Throwable $th) {
      return response()->json([
        'error' => $th->getMessage()
      ]); 
    }
  }



  
}
