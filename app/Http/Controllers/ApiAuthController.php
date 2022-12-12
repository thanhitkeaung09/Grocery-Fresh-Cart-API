<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
           "name"=>"required",
           "email"=>"required|unique:users",
           "password"=>"required|confirmed|min:8",
//           "confirmed_password"=>"same:password"
        ]);

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

//        if(Auth::attempt($request->only(['email','password']))){
//            $token = Auth::user()->createToken("phone")->plainTextToken;
//            return response()->json($token);
//        }
//
//        return response()->json(["message"=>"User is created"],200);

        return response()->json([
           "message" => "User is created",
           "success" => true
        ]);
    }

    public function login(Request $request){

        $request->validate([
            "email"=>"required",
            "password"=>"required|min:8|max:8",
        ]);


        if(Auth::attempt($request->only(['email','password']))){
            $token = Auth::user()->createToken("phone")->plainTextToken;
            return response()->json([
                "message" => "login success",
                "success" => true,
                "token" => $token,
                "auth" => new UserResource(Auth::user())
            ],200);
        }


        return response()->json([
            "message"=>"User Login Fail",
            "success" => false
            ],404);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return "Logout Successfully";
    }
}
