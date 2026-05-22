<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return ApiResponse::success('User Registered Successfully', [

            'user' => $user,

            'token' => $token
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            return ApiResponse::error('Invalid Credentials', 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return ApiResponse::success('Login Successful', [

            'user' => $user,

            'token' => $token
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return ApiResponse::success('Logout Successful');
    }
}