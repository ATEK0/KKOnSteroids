<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Wishlist;
use App\Models\WishlistListContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function get(Request $request)
    {
        $authentication = new AuthController();

        $user = $authentication->me($request);

        if ($user) {

            $wishlists = Wishlist::where("ownedBy", $user->id)->get();

            foreach ($wishlists as $wishlist) {

                $wishlistItems = WishlistListContent::where("wishlistID", $wishlist->id)->get();

                if ($wishlistItems) {

                    $wishlistContent = Products::whereIn('id', $wishlistItems->pluck('productID'))->get();

                    $wishlist->content = $wishlistContent;
                }
            }

            return $wishlists;
        }
        return response()->json(["Please Login"], 200);
    }

    public function store(Request $request)
    {
        $authentication = new AuthController();

        $user = $authentication->me($request);

        if ($user) {

            $wishlist = new Wishlist();
            $wishlist->name = $request->name;
            $wishlist->ownedBy = $user->id;

            $wishlist->save();

            return response()->json(["Wishlist Created"], 200);
        }

        return response()->json(["no user found"], 200);
    }

    public function addProductToWishlist(Request $request)
    {

        $wishlists = $this->get($request);

        $wishlistIDs = $wishlists->pluck('id')->toArray();

        if (in_array($request->wishlistID, $wishlistIDs)) {

            $wishlistItem = new WishlistListContent();

            $wishlistItem->wishlistID = $request->wishlistID;
            $wishlistItem->productID = $request->productID;

            $wishlistItem->save();

            return response()->json(["Product added to wishlist"], 200);
        } else {
            return response()->json(["Invalid wishlist ID"], 400);
        }
    }

    public function getProductPresences(Request $request)
    {
        $wishlists = $this->get($request);

        $wishlistIDs = $wishlists->pluck('id')->toArray();

        $wishlistsContainingProduct = WishlistListContent::where('productID', $request->productID)
            ->whereIn('wishlistID', $wishlistIDs)
            ->get();

        return $wishlistsContainingProduct;
    }

    public function removeProductFromWishlist(Request $request)
    {
        $wishlists = $this->get($request);

        $wishlistIDs = $wishlists->pluck('id')->toArray();

        if (in_array($request->wishlistID, $wishlistIDs)) {

            $wishlistItem = WishlistListContent::where('productID', $request->productID)->where('wishlistID', $request->wishlistID)->first();

            $wishlistItem->delete();

            return response()->json(["Product removed from wishlist"], 200);
        } else {
            return response()->json(["Invalid wishlist ID"], 400);
        }
    }
}
