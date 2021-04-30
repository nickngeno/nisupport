<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;
use Validator;

class AuthController extends Controller
{
  //Authentication insurance
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    //login User

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    //Register User
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|between:2,100',
            'lastName' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    //Log the user out (Invalidate the token).

    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    //Refresh a token.
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

     // Get the authenticated User.

    public function userProfile() {
        return response()->json(auth()->user());
    }

    //Get the token array structure.

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

}
