<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PriceHistoryController;
use App\Http\Controllers\ProductRequestsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TargetPriceController;
use App\Http\Controllers\PriceScrapperController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});

//auth routes
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);
Route::post("/me", [AuthController::class, "me"]);


//permission routes
Route::post("/checkIfAdmin", [AuthController::class, "checkIfAdmin"]);

//categories routes
Route::post("/getCategories", [CategoriesController::class, "getCategories"]);
Route::post("/getCategoriesCount", [CategoriesController::class, "getCount"]);
Route::post("/createCategory", [CategoriesController::class, "create"]);
Route::post("/updateCategory", [CategoriesController::class, "update"]);
Route::post("/deleteCategory", [CategoriesController::class, "delete"]);

//products routes
Route::post("/getProductsCount", [ProductsController::class, "getCount"]);
Route::post("/createProduct", [ProductsController::class, "store"]);
Route::post("/getProduct", [ProductsController::class, "show"]);
Route::post("/getMarkets", [ProductsController::class, "getMarkets"]);
Route::post("/getProducts", [ProductsController::class, "getProducts"]);
Route::post("/deleteProduct", [ProductsController::class, "delete"]);
Route::post("/updateProduct", [ProductsController::class, "update"]);
Route::post("/mostView", [ProductsController::class, "getMostView"]);
Route::post("/getHotDeal", [ProductsController::class, "getHotDeal"]);
Route::post("/getProductsByCategory", [ProductsController::class,"getProductsByCategory"]);
Route::post("/getRecomendedProducts", [ProductsController::class,"getRecommendedProducts"]);
Route::post("/searchQueryFromSearchBar", [ProductsController::class,"getProductsInSearchBar"]);
Route::post("/getProductsFromSearch", [ProductsController::class,"getProductsFromSearch",]);
Route::get("/getBrands", [ProductsController::class,"getBrands",]);


//product request routes
Route::post("/getRequestsCount",[ProductRequestsController::class,"getCount"]);
Route::post("/requestProduct", [ProductRequestsController::class, "store"]);
Route::post("/getRequestProducts", [ProductRequestsController::class, "getAll"]);
Route::post("/getRequest", [ProductRequestsController::class, "get"]);
Route::post("/refuseRequest", [ProductRequestsController::class, "refuse"]);
Route::post("/activateRequest", [ProductRequestsController::class, "activate"]);

//user routes
Route::post("/getUsersCount", [UserController::class, "getCount"]);
Route::post("/getUsers", [UserController::class, "getUsers"]);
Route::post("/updateAccount", [UserController::class, "update"]);
Route::post("/deleteAccount", [UserController::class,"delete"]);

//webscrapper
Route::post("/scrapper", [PriceScrapperController::class, "index"]);

//wishlists
Route::post("/getWishlists", [WishlistController::class,"get"]);
Route::post("/createWishlist", [WishlistController::class,"store"]);
Route::post("/addProductToWishlist", [WishlistController::class,"addProductToWishlist"]);
Route::post("/removeProductFromWishlist", [WishlistController::class,"removeProductFromWishlist"]);
Route::post("/getProductPresences", [WishlistController::class,"getProductPresences"]);
Route::post("/getWishlist", [WishlistController::class,"getWishlist"]);

//price history
Route::post("/getPriceHistory", [PriceHistoryController::class,"getPricesLast30Days"]);

//banners
Route::get("/getBanners", [BannersController::class,"getBanners"]);
Route::post("/createBanner", [BannersController::class,"addBanner"]);
Route::post("/deleteBanner", [BannersController::class,"deleteBanner"]);

//mail
Route::get('/send-test-mail', [EmailController::class, 'sendPriceTargetMail']);

//target price
Route::post('/getTargetPrice', [TargetPriceController::class, 'getTargetPrice']);
Route::post('/setTargetPrice', [TargetPriceController::class, 'setTargetPrice']);


