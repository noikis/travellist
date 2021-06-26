<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $fields = $request->validated();
        User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'remember_token' => Str::random(10)
        ]);
        $response = [
            'data' => null,
            'message' => "Registered!"
        ];
        return response($response, 201);
    }

    public function login(LoginRequest $request)
    {
        $fields = $request->validated();
        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check Password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad credentials',
            ], 401);
        }
        $response = [
           'data' => [
               'access_token' => $user->createToken('access_token')->plainTextToken,
               'refresh_token' => $user->getRememberToken()
           ],
            'message' => 'Logged!'
        ];
        return response($response, 201);
    }

    public function logout()
    {
        // destroy all access tokens of auth user
        auth()->user()->tokens()->delete();

        return [
            'data' => null,
            'message' => 'Logged out!.'
        ];
    }

    public function refresh(Request $request)
    {
        $user = auth()->user();

        // Validating the refresh_token
        if (!$request->refresh_token || $request->refresh_token !== $user->getRememberToken()) {
            return response([
                'message' => 'Wrong token',
            ], 403);
        }
        $user->tokens()->delete();

        $response = [
            'data' => [
                'access_token' => $user->createToken('access_token')->plainTextToken,
            ],
            'message' => 'Refreshed!'
        ];
        return response($response, 201);
    }
}
