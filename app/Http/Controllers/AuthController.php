<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\ProfileViewResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $token = User::store($request);
        return response()->json([
            'message' => 'User created successfully',
            // 'data' => $user,
            'token' => $token
        ], 200);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|string|max:255',
            'password'  => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        $user   = User::where('email', $request->email)->firstOrFail();
        $token  = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    public function index(Request $request)
    {
        // $user = $request->user();

        // // $user = ProfileViewResource::collection($user);
        // $permissions = $user->getAllPermissions();
        // $roles = $user->getRoleNames();
        if (Auth::check()) {
            $user = $request->user();
            $user = new ProfileViewResource($user);
            return response()->json([
                'message' => 'Login success',
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'message' => 'Login success',
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['error' => 'User not found!.'], 200);
    }

    public function resetPassword(Request $request){
        $resetData = DB::table('reset_passwords')
        ->where('passcode',$request->passcode)
        ->first();
        if(!$resetData){
            return response()->json(['error' => 'Invalid passcode!.'], 200);
        }

        $user = User::where('email',$resetData->email)->first();
        if(!$user){
            return response()->json(['error' => 'User not found!.'], 200);
        }
        $user->password =  Hash::make($request->password);
        $user->save();
        DB::table('reset_password')->where('passcode',$request->passcode)->delete();
        return response()->json(['message' => 'Password reset successfully.'], 200);
    }
}
