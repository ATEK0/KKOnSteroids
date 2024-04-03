<?php

namespace App\Http\Controllers;

use App\Traits\ScrapperTrait;
use Illuminate\Http\Request;

class PriceScrapperController extends Controller
{
    public function index(Request $request)
    {

        $scraper = new ScrapperTrait();
        // $url = "https://www.radiopopular.pt/produto/apple-iphone-14-128gb-black-1#";
        // $url = "https://www.fnac.pt/Smartphone-Xiaomi-Redmi-Note-12-4G-256-GB-Preto-Telemovel-SmartPhone-Android/a11427536";
        // $url = "https://www.worten.pt/produtos/tinta-anti-mofo-aquosa-pectro-com-aditivos-anti-mofo-e-anti-humidade-3-6-l-5-kg-branco-previne-bolor-mrkean-8435196917092";
        // $url = "https://mediamarkt.pt/products/maquina-fotografica-canon-eos-r100-rf-s-18-45mm-is-stm";
        // $url = "https://www.aquario.pt/en/product/xiaomi-xiaomi-redmi-note-13-pro-169-cm-667-dual-sim-rb50896";
        // $url = "https://castroelectronica.pt/en/product/smartwatch-mibro-watch-x1-13-preto--xiaomi";
        // $url = "https://ligatu.pt/produto/adaptador-de-corrente-usb-c-de-20w-branco/";

        $price = $scraper->scrapePrice($request->url, $request->element);

        if ($price) {
            return response()->json(['price' => $price]);
        } else {
            return response()->json('error');
        }
    }
}
