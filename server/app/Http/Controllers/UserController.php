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
}
