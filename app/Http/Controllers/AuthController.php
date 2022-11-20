<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    # Make register feature
    public function register(Request $request)
    {
        # Catch the input
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        # Insert data to user table
        $user = User::create($input);

        $data = [
            "message" => "User is created successfully",
        ];

        # Response response json
        return response()->json($data, 201);
    }

    # Make login feature
    public function login(Request $request)
    {
        # Catch User Input
        $input = [
            "email" => $request->email,
            "password" => $request->password,
        ];

        # Authentication
        if (Auth::attempt($input)) {
            # Generate token
            $token = Auth::user()->createToken('auth_token');

            $data = [
                "message" => "Login success",
                "token" => $token->plainTextToken,
            ];

            # Return response json
            return response()->json($data, 200);
        } else {
            $data = [
                "message" => "Username or Password is wrong",
            ];

            # Return response json
            return response()->json($data, 401);
        }
    }
}
