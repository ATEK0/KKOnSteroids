<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\ProductCategories;
use App\Models\ProductRequests;
use App\Models\Products;
use App\Models\ProductLinks;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ProductsController extends Controller
{
    public function getCount(Request $request)
    {

        $auth = new AuthController();

        if ($auth->checkIfAdmin($request)) {
            return Products::all()->count();
        } else {
            return "not authorized";
        }
    }

    public function getProducts(Request $request)
    {
        $auth = new AuthController();
        if ($auth->checkIfAdmin($request)) {

            return cache()->remember('all_products', 15, function () {
                return Products::all();
            });
        } else {
            return response()->json("Not authorized", 200);
        }
    }


    public function store(Request $request)
    {
        $auth = new AuthController();



        if ($auth->checkIfAdmin($request)) {
            $user = $auth->me($request);

            $product_info = $request->payload;

            $product = new Products();


            $product->name = $product_info['name'];
            $product->brand = $product_info['brand'];
            $product->size = $product_info['size'];
            $product->requestID = $product_info['request_id'];
            $product->created_by = $user->id;
            $product->description = $product_info['description'];
            $product->slug = '';
            $product->productImage = $product_info['productImage'];
            $product->lowerprice = '9999999999999';
            $product->save();
            $product->slug = preg_replace('/\s+/', '-', $product_info['name']) . '-' . $product->id;
            $product->save();

            for ($i = 0; $i < count($product_info['category']); $i++) {

                $product_categories = new ProductCategories();

                $product_categories->category_id = $product_info['category'][$i]['id'];
                $product_categories->product_id = $product->id;
                $product_categories->save();
            }


            for ($i = 0; $i < count($product_info['links']); $i++) {

                $product_links = new ProductLinks();
                $scraper = new WebScrapperService();

                $product_links->product_id = $product->id;
                $product_links->link = $product_info['links'][$i]['link'];
                $product_links->HTML_price_element = $product_info['htmlElements'][$i];

                $product_links->hostname = parse_url($product_info['links'][$i]['link'], PHP_URL_HOST);
                $product_links->hostname = str_replace(array('www.', '.pt', '.com', '.es', '.uk', '.com.pt', '.com.br', '.br', '.fr'), '', $product_links->hostname);

                $productPrice = $scraper->scrapePrice($product_info['links'][$i]['link'], $product_info['htmlElements'][$i]);

                $product_links->product_price = number_format((float)(str_replace(array('$', '€', '£'), '', $productPrice)), 2, '.', '');

                if ($product_links->product_price < $product->lowerprice) {

                    $product->lowerprice = $product_links->product_price;
                    $product->save();
                }

                $product_links->save();
            }


            $productRequest = ProductRequests::where('id', $product->requestID)->first();
            if ($productRequest) {
                $productRequest->status = '2';
                $productRequest->save();
            }


            return response()->json("Created", 200);
        } else {
            return "not authorized";
        }
    }

    public function show(Request $request)
    {
        $product = Products::where('slug', $request->slug)->first();

        if (!$product) {
            return response()->json('', 200);
        }
        $product->clicks = $product->clicks + 1;
        $product->save();

        $categories = ProductCategories::where('product_id', $product->id)
            ->join('categories', 'product_categories.category_id', '=', 'categories.id')
            ->select('categories.*')
            ->get();


        $product->categories = $categories;

        $links = ProductLinks::where('product_id', $product->id)->get();

        $product->links = $links;

        $elements = ProductLinks::where('product_id', $product->id)->get('HTML_price_element');

        $product->HTMLelements = $elements;

        return $product;
    }

    public function getMarkets(Request $request)
    {
        return ProductLinks::where('product_id', $request->id)->get();
    }

    public function delete(Request $request)
    {
        $auth = new AuthController();
        if ($auth->checkIfAdmin($request)) {

            $product = Products::findOrFail($request->id);
            ProductLinks::where('product_id', $product->id)->delete();
            ProductCategories::where('product_id', $product->id)->delete();

            $product->delete();

            return response()->json('deleted', 200);
        } else {
            return response()->json("Not authorized", 401);
        }
    }

    public function update(Request $request)
    {
        $auth = new AuthController();

        if ($auth->checkIfAdmin($request)) {
            $user = $auth->me($request);

            $product_info = $request->payload;

            $product = Products::findOrFail($product_info["id"]);


            $product->name = $product_info['name'];
            $product->brand = $product_info['brand'];
            $product->size = $product_info['size'];
            $product->requestID = $product_info['request_id'];
            $product->created_by = $user->id;
            $product->description = $product_info['description'];
            $product->slug = '';
            $product->lowerprice = '9999999999999';
            $product->save();
            $product->slug = preg_replace('/\s+/', '-', $product_info['name']) . '-' . $product->id;
            $product->save();


            // delete all categories linked to this product
            ProductCategories::where('product_id', $product->id)->delete();

            for ($i = 0; $i < count($product_info['category']); $i++) {

                $product_categories = new ProductCategories();

                $product_categories->category_id = $product_info['category'][$i]['id'];
                $product_categories->product_id = $product->id;
                $product_categories->save();
            }


            // delete all links linked to this product
            ProductLinks::where('product_id', $product->id)->delete();

            for ($i = 0; $i < count($product_info['links']); $i++) {

                $product_links = new ProductLinks();
                $scraper = new WebScrapperService();

                $product_links->product_id = $product->id;
                $product_links->link = $product_info['links'][$i]['link'];
                $product_links->HTML_price_element = $product_info['htmlElements'][$i]['HTML_price_element'];

                $product_links->hostname = parse_url($product_info['links'][$i]['link'], PHP_URL_HOST);
                $product_links->hostname = str_replace(array('www.', '.pt', '.com', '.es', '.uk', '.com.pt', '.com.br', '.br', '.fr'), '', $product_links->hostname);

                $productPrice = $scraper->scrapePrice($product_info['links'][$i]['link'], $product_info['htmlElements'][$i]['HTML_price_element']);

                $product_links->product_price = number_format((float)(str_replace(array('$', '€', '£'), '', $productPrice)), 2, '.', '');

                if ($product_links->product_price < $product->lowerprice) {

                    $product->lowerprice = $product_links->product_price;
                    $product->save();
                }

                $product_links->save();
            }


            $productRequest = ProductRequests::where('id', $product->requestID)->first();
            if ($productRequest) {
                $productRequest->status = '2';
                $productRequest->save();
            }


            return response()->json("Created", 200);
        } else {
            return "not authorized";
        }
    }

    public function getMostView()
    {
        return Products::orderBy('clicks', 'desc')->take(10)->get();
    }

    public function getHotDeal()
    {
        return Products::where('isTodayStar', '=', 1)->first();
    }

    public function getProductsByCategory(Request $request)
    {
        $categoryName = $request->category;

        $category = Categories::where('name', $categoryName)->first();

        if (!$category) {
            return response()->json(['error' => ''], 404);
        }

        $categoryProducts = ProductCategories::where('category_id', $category->id)->get();

        $productIds = $categoryProducts->pluck('product_id')->toArray();

        $products = Products::whereIn('id', $productIds)->get();

        return response()->json($products, 200);
    }

    public function getRecommendedProducts(Request $request)
    {
        $categoryIds = $request->category_id;

        $flattenedCategoryIds = Arr::flatten($categoryIds);

        $categoryProducts = ProductCategories::whereIn('category_id', $flattenedCategoryIds)->get();

        $productIds = $categoryProducts->pluck('product_id')->toArray();

        $products = Products::whereIn('id', $productIds)->take(8)->get();

        return response()->json($products, 200);
    }
}
