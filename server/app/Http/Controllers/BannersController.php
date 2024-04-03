<?php

namespace App\Http\Controllers;

use App\Models\Banners;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    public function getBanners(Request $request)
    {

        $banners = Banners::all();
        return $banners;
    }

    public function addBanner(Request $request)
    {
        $auth = new AuthController();

        if ($auth->checkIfAdmin($request)) {

            $banner = new Banners();
            $banner->imageLink = $request->imageLink;
            $banner->save();

            return "Banner Added";
        } else {
            return "not authorized";
        }
    }

    public function deleteBanner(Request $request)
    {
        $auth = new AuthController();

        if ($auth->checkIfAdmin($request)) {

            $banner = Banners::where('id', $request->id)->first();
            $banner->delete();

            return "Banner Deleted";
        } else {
            return "not authorized";
        }
    }
}
