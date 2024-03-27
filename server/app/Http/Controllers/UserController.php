<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\User;

class UserController extends Controller
{
    public function getCount(Request $request)
    {

        $auth = new AuthController();

        if ($auth->checkIfAdmin($request)) {
            return User::where("role", 1)->count();
        } else {
            return "not authorized";
        }
    }

    public function getUsers(Request $request)
    {
        $auth = new AuthController();
        if ($auth->checkIfAdmin($request)) {
            return User::where("role", 1)->get();
        }
    }

    public function delete(Request $request)
    {

        $auth = new AuthController();
        if ($auth->checkIfAdmin($request)) {

            User::find($request->id)->delete();

            return response()->json(['message' => 'User deleted'], 201);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function update(Request $request)
    {
        $auth = new AuthController();

        if ($auth->checkIfAdmin($request)) {

            $user = User::where('id', '=', $request->idtoChange)->first();

            $emailExist = User::where('email', $request->email)->first();

            if ($emailExist && $user->email != $request->email) {
                return response()->json(['error' => 'Email Already in Use'], 409);
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
}
