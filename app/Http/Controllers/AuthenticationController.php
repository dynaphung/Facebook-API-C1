<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\StoreRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function register(StoreRegisterRequest $request) {
        $credentails = $request->only('name', 'email', 'password');

        $credentails["password"] = bcrypt($credentails["password"]);
        $user = User::create($credentails);
        $token = $user->createToken('API Token', ['select', 'create', 'update'])->plainTextToken;

        return response()->json([
            'user'=> $user,
            'token'=> $token
        ], 200);
    }

    public function login(StoreLoginRequest $request) {
        $credentails = $request->only('name', 'email', 'password');
        if (Auth::attempt($credentails)) {
            $user = Auth::user();
            $token = $user->createToken('API Token', ['select', 'create', 'update'])->plainTextToken;
            return response()->json([
                'user'=> $user,
                'token'=> $token
            ], 200);
        }
        return response()->json(['message'=> 'Invalid credentails.'], 200);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message'=> 'Logout successfully.'], 200);
    }
}
