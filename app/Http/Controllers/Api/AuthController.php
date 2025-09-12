<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 201);
        }catch (\Exception $exception){
            return response()->json([
                'message' => 'Registration failed',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $data['email'])->first();

            if (!$user || !Hash::check($data['password'], $user->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        }catch (\Exception $exception){
            return response()->json([
                'message' => 'Login failed',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message' => 'Logged out'
            ], 200);
        }catch (\Exception $exception){
            return response()->json([
                'message' => 'Logout failed',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
