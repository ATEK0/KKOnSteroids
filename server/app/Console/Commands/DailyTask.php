<?php

namespace App\Console\Commands;

use App\Http\Controllers\EmailController;
use App\Models\ProductLinks;
use App\Models\Products;
use App\Models\TargetPrice;
use App\Traits\ScrapperTrait;
use Illuminate\Console\Command;
use App\Models\PriceHistory;
use App\Models\User;

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
    protected $description = 'This script perform daily tasks, should be ran everyday';

    /**
     * Execute the console command.
     */

    public function handle()
    {

        $products = Products::all();

        echo "Checking prices...\n";

        $productsCount = $products->count();

        $prodCounter = 0;

        foreach ($products as $product) { //check each product

            $product->isTodayStar = 0;
            $links = ProductLinks::where('product_id', $product->id)->get();
            $minPrice = 999999999999999999;

            foreach ($links as $link) { //check all the links linked to that product

                $scraper = new ScrapperTrait();

                $productPrice = $scraper->scrapePrice( //scrap the price for the link
                    $link->link,
                    $link->HTML_price_element
                );

                if ($productPrice < $minPrice) { //checks if the price is lower than the lowest price checked in this loop
                    $minPrice = $productPrice;
                }
                $link->product_price = str_replace(['$', "€", "£"], "", $productPrice); // formats the product price to look like ##.##
                $link->product_price = str_replace([","], ".", $link->product_price);

                $link->save();
            }
            $product->lowerprice = $minPrice; //saves the lower price into the product row
            $product->save();

            $this->update_price_chart($product->id, $product->lowerprice);

            $prodCounter += 1;

            echo round((($prodCounter * 100) / $productsCount), 0) . "%\n";
        }

        $isTodayStar = Products::inRandomOrder()->first();

        $isTodayStar->isTodayStar = 1;

        $isTodayStar->save();

        $this->triggerPriceAlerts();

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

    private function triggerPriceAlerts()
    {
        echo "\nChecking Price targets\n";
        # trigger price alerts

        $target_price = TargetPrice::all();

        foreach ($target_price as $target) { // checks all alerts

            $product = Products::where('id', $target->productID)->first(); // get product referenced in that alert

            if ($product->lowerprice <= $target->target_price) { // if the price product is lower or equal to the target, gets the user that created the target and sends an email to his account telling the target was reached

                $user = User::where('id', $target->userID)->first();

                $mailSender = new EmailController();

                $mailSender->sendPriceTargetMail($product, $user, $target);

                $target->delete();

            }
        }
    }
}
