<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PriceHistory;
use App\Models\Products;
use Carbon\Carbon;

class PriceHistoryController extends Controller
{
    public function getPricesLast30Days(Request $request)
    {

        $today = date('Y-m-d');
        $last30 = Carbon::now()->subDays(30)->format('Y-m-d');

        $product = Products::where('slug', $request->slug)->first();

        $prices = PriceHistory::where("product_id", $product->id)
        ->whereBetween("date_scrapped", [$last30, $today])
        ->get(['product_price as y', 'date_scrapped as label']);

        foreach ($prices as $price) {

            $price->y = floatval($price->y);

        }

        return $prices;
    }
}
