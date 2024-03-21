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

    public function update(Request $request)
    {
        if ($this->checkIfAdmin($request)) {

            $user = User::where('id', '=', $request->idtoChange)->first();

            $emailExist = User::where('email', $request->email)->first();

            if ($emailExist && $user->email != $request->email) {
                return response()->json(['error'=> 'Email Already in Use'], 409);
            }

            $user->name = $request->name;
            $user->email = $request->email;

            if ($user->password) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            return response()->json(['message' => 'User registred'], 201);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function delete(Request $request)
    {
        if ($this->checkIfAdmin($request)) {

            User::find($request->id)->delete();

            return response()->json(['message' => 'User deleted'], 201);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request)
    {
        return response()->json([], 200);
    }

    public function me(Request $request)
    {
        $token = $request->bearerToken();

        $JWTdecoded = JWTAuth::parseToken()->authenticate();

        $user = User::where('email', $JWTdecoded->email)->first();

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
