<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categories;
use App\Models\ProductRequests;
use Illuminate\Database\Eloquent\Casts\Json;

class CategoriesController extends Controller
{
    public function getCategories()
    {
        return Categories::all();
    }

    public function getCount()
    {
        return Categories::all()->count();
    }

    public function create(Request $request) {
        
        $newCategory = new Categories();

        if (Categories::where('name', '=', $request->name)->first()) {
            return response()->json(["already exists"], 200);
        }

        $newCategory->name = $request->name;
        $newCategory->imageLink = $request->imageLink;

        $newCategory->save();

        return response()->json("created", 200);
    }

    public function update(Request $request) {
        $category = Categories::find($request->id);

        if (Categories::where('name', '=', $request->name)->first()) {
            return response()->json(["already exists"], 200);
        }

        $category->name = $request->name;
        $category->imageLink = $request->imageLink;

        $category->save();

        return response()->json("Updated",200);
    }

    public function delete(Request $request) {
        $category = Categories::find($request->id);
        $category->delete();

        return response()->json("Updated",200);
    }
}
