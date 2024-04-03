<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthController;

use App\Models\TargetPrice;
use Illuminate\Http\Request;

class TargetPriceController extends Controller
{
    public function getTargetPrice(Request $request)
    {

        $user = new AuthController();
        $user = $user->me($request);

        // dd($request->productID, $user->id);
        $target_price = TargetPrice::where('productID', $request->productID)->where('userID', $user->id)->first();

        if (!$target_price) {
            return 'No target';
        }

        return $target_price->target_price;
    }

    public function setTargetPrice(Request $request)
    {

        $user = new AuthController();
        $user = $user->me($request);

        $target_price = TargetPrice::where('productID', $request->productID)->where('userID', $user->id)->first();

        if (!$target_price) {

            $target_price = new TargetPrice();
        }

        $target_price->productID = $request->productID;
        $target_price->userID = $user->id;

        if ($request->target_price) {

            $target_price->target_price = $request->target_price;
        } else {

            $target_price->target_price = 'No target';
        }

        $target_price->save();

        return "Alert Created";
    }
}
