<?php

namespace App\Console\Commands;

use App\Models\ProductLinks;
use App\Models\Products;
use Illuminate\Console\Command;
use App\Http\Controllers\WebScrapperService;
use App\Models\PriceHistory;

class DailyTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function handle()
    {

        $products = Products::all();


        foreach ($products as $product) { //check each product

            $product->isTodayStar = 0;
            $links = ProductLinks::where('product_id', $product->id)->get();
            $minPrice = 99999999999999999;
            echo '- ' . $product->id;
            foreach ($links as $link) { //check all the links linked to that product

                $scraper = new WebScrapperService();

                $productPrice = $scraper->scrapePrice( //scrap the price for the link
                    $link->link,
                    $link->HTML_price_element
                );

                if ($productPrice < $minPrice) { //checks if the price is lower than the lowest price checked in this loop
                    $minPrice = $productPrice;
                }
                $link->product_price = number_format( // formats the product price to look like ##.##
                    (float) str_replace(['$', "€", "£"], "", $productPrice),
                    2,
                    ".",
                    ""
                );
                $link->save();
            }
            $product->lowerprice = $minPrice; //saves the lower price into the product row
            $product->save();

            $this->update_price_chart($product->id, $product->lowerprice);
        }

        $isTodayStar = Products::inRandomOrder()->first();

        $isTodayStar->isTodayStar = 1;

        $isTodayStar->save();

    }
    private function update_price_chart($product_id, $product_price)
    {
        $price_registry = PriceHistory::where("product_id", $product_id)->where("date_scrapped", date('Y-m-d'))->first();

        if (!$price_registry) {
            $price_registry = new PriceHistory();
        }

        $price_registry->product_price = $product_price;
        $price_registry->product_id = $product_id;
        $price_registry->date_scrapped = date('Y-m-d');

        $price_registry->save();
    }
}
