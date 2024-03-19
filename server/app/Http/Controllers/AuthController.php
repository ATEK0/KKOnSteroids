<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_Roles;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['token' => $token], 200);
    }


    public function register(Request $request)
    {

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);

        return response()->json(['message' => 'User registred'], 201);
    }

    public function logout(Request $request)
    {
        return response()->json([], 200);
    }

    public function me(Request $request)
    {
        try {
            $token = $request->bearerToken();

            $JWTdecoded = JWTAuth::parseToken()->authenticate();

            $user = User::where('email', $JWTdecoded->email)->first();

            $userRoleLabel = User_Roles::where('id', $user->role)->first();

            $user->role = $userRoleLabel->role;

            return $user;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function checkIfAdmin(Request $request)
    {

        $user = $this->me($request);

        if ($user->role == 'Admin') {
            return true;
        }

        return false;
    }

    public function checkLogin(Request $request)
    {
        try {
            $token = $request->bearerToken();
            $token = JWTAuth::getToken();
            JWTAuth::parseToken()->authenticate();
        } catch (\Throwable $th) {
            return false;
        }

        return true;
    }
}
