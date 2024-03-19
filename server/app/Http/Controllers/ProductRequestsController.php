<?php

namespace App\Http\Controllers;

use App\Models\ProductRequests;
use App\Models\ProductRequestLinks;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;


class ProductRequestsController extends Controller
{
    public function getCount(Request $request)
    {
        $auth = new AuthController();

        if ($auth->checkIfAdmin($request)) {
            return ProductRequests::all()->count();
        }
    }

    public function getAll(Request $request)
    {
        $auth = new AuthController();

        if ($auth->checkIfAdmin($request)) {

            $productRequests = ProductRequests::join('status_role', 'product_requests.status', '=', 'status_role.id')
                ->join('users', 'product_requests.requested_by', '=', 'users.id')
                ->select('product_requests.*', 'status_role.status', 'users.name as requested_by')
                ->get();

            return $productRequests;
        } else {
            return response()->json([], 401);
        }
    }

    public function store(Request $request)
    {

        // try {

        $user = new AuthController();
        $user = $user->me($request);

        $new_request = new ProductRequests();

        $new_request->name = $request->name;


        $new_request->brand = $request->brand;
        $new_request->size = $request->size;

        $new_request->requested_by = $user->id;

        $new_request->save();


        foreach ($request->links as $link) {
            ProductRequestLinks::create([
                'request_id' => $new_request->id,
                'link' => $link,
            ]);
        }

        return response()->json(['message' => 'created'], 200);
        // } catch (\Throwable $th) {
        //     return response()->json(['message' => 'Something went wrong, try again'], 400);
        // }
    }

    public function get(Request $request)
    {
        $user = (new AuthController())->me($request);

        if ($user->role != 'Admin') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $requestData = ProductRequests::join('status_role', 'product_requests.status', '=', 'status_role.id')
            ->join('users', 'product_requests.requested_by', '=', 'users.id')
            ->select('product_requests.*', 'status_role.status', 'users.name as requested_by', 'users.id as requesterID')
            ->where('product_requests.id', $request->requestID)
            ->first();

        $requestLinks = ProductRequestLinks::where('request_id', $requestData->id)->get();

        $requestData->links = $requestLinks;

        return response()->json($requestData, 200);
    }

    public function refuse(Request $request)
    {
        $user = (new AuthController())->me($request);

        if ($user->role != 'Admin') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $requestData = ProductRequests::findOrFail($request->input('requestID'));

        $requestData->status = "3";

        $requestData->save();

        return response()->json("deleted", 200);
    }

    public function activate(Request $request)
    {
        $user = (new AuthController())->me($request);

        if ($user->role != 'Admin') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $requestData = ProductRequests::findOrFail($request->input('requestID'));

        $requestData->status = "1";

        $requestData->save();

        return response()->json("active", 200);
    }

    public function update(Request $request)
    {

        $user = (new AuthController())->me($request);

        if ($user->role != 'Admin') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        dd($request->all());

    }
}
