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

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);

        return response()->json(['message' => 'User registred'], 201);
    }

    public function me(Request $request)
    {
        $token = $request->bearerToken();

        $JWTdecoded = JWTAuth::parseToken()->authenticate();

        $user = User::where('email', $JWTdecoded->email)->first();

        $user->last_beat = date('d-m-y h:i:s');

        $user->save();

        $userRoleLabel = User_Roles::where('id', $user->role)->first();

        $user->role = $userRoleLabel->role;

        return $user;
    }

    public function checkIfAdmin(Request $request)
    {

        $user = $this->me($request);

        if ($user->role == 'Admin') {
            return true;
        }

        return false;
    }
}
