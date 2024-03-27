<?php

namespace Database\Seeders;

use App\Models\PriceHistory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PriceChartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        // Calculate the end date (today - 30 days)
        $endDate = Carbon::now()->subDays(30);

        $productId = 2;
        $productPrice = 1010;

        // Start from today's date and go back until the end date
        $currentDate = Carbon::now();
        while ($currentDate->gte($endDate)) {
            // Create a new record in the PriceHistory table
            PriceHistory::create([
                'product_id' => $productId,
                'product_price' => $productPrice,
                'date_scrapped' => $currentDate
            ]);

            // Move to the previous day
            $currentDate->subDay();
        }
    }
}
