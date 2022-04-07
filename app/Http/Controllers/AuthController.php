<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('authToken')->plainTextToken;

            return response([
                'access_token' => $token,
                'token_type' => 'Bearer'
            ], Response::HTTP_OK);
        } else {

            return response([
                'message' => 'Unauthenticated',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function register(UserRequest $request)
    {
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->all());
        $token = $user->createToken('authToken')->plainTextToken;

        return response([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], Response::HTTP_CREATED);
    }
}
