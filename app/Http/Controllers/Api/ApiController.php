<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    //  POST [name, email, password]
    public function register(Request $request){

        // validate
        $request->validate([
            "name" => "required|string",
            "email" => "required|string|email|unique:users",
            "password" => "required|confirmed"
        ]);

        //users
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        return response()->json([
            "status" => true,
            "message" => "User registred succesfully",
            "data" => []
        ]);
    }

    //  POST [email, password]
    public function login(Request $request){

        // validate ...
        $request->validate([
            "email" => "required|email|string",
            "password" => "required"
        ]);

        // Email verifing ...
        $user = User::where("email", $request->email)->first();

        if (!empty($user)){

            // User exists ...
            if (Hash::check($request->password, $user->password)){

                // password sync
                $token = $user->createToken("mytoken")->plainTextToken;

                return response()->json([
                    "status" => true,
                    "message" => "User logged in",
                    "token" => $token,
                    "data" => []
                ]);
            }else{
                return response()->json([
                    "status" => false,
                    "message" => "Invalid password",
                    "data" => []
                ]);
            }
        }else{
            return response()->json([
                "status" => false,
                "message" => "Email doesn't match with records",
                "data" => []
            ]);
        }
    }

    // GET [Auth: Token]
    public function profile(Request $request){
        $userData = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile Information",
            "data" => $userData,
            "id" => auth()->user()->id
        ]);
    }

    // GET [Auth: Token]
    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return response()->json([
            "status" => true,
            "message" => "User logged out..",
            "data" => []
        ]);
    }
}
