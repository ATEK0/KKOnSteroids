<?php

namespace App\Traits;


use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScrapperTrait
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    // public function scrapePrice($url, $HTML_element)
    public function scrapePrice($url, $element)
    {
        try {
            // Send a GET request to the URL
            $response = $this->client->get($url);

            // Check if the request was successful
            if ($response->getStatusCode() === 200) {
                // Parse the HTML content of the page
                $html = $response->getBody()->getContents();
                $crawler = new Crawler($html);


                // $price = $crawler->filter('.price')->text(); //for radio popular
                // $price = $crawler->filter('.f-faPriceBox__price')->text(); //for fnac (bloqueada)
                // $price = $crawler->filter('.value')->text(); //for worten
                // $price = $crawler->filter('.bigprices')->text(); //for media markt
                // $price = $crawler->filter('.product-detail-price')->text(); //for aquario (bloqueado)
                // $price = $crawler->filter('.product-opportunity-new-price')->text(); //for castro eletronica
                // $price = $crawler->filter('#pdp-price-current-integer')->text(); //for pc componentes (bloqueado)
                // $price = $crawler->filter('.tracking-tighter')->text(); //for chip7
                // $price = $crawler->filter('.price__amount')->text(); //for globaldata (bloqueado)
                // $price = $crawler->filter('bdi')->text(); //for ligatu
                $price = $crawler->filter($element)->text();

                return $price;
            } else {
                // If the request was unsuccessful, return null
                return null;
            }
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., connection errors, parsing errors)
            return null;
        }
    }
}
