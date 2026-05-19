<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class LandingController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $productsByCategory = [];
        foreach ($categories as $category) {
            $productsByCategory[$category->slug] = Product::where('category_id', $category->id)
                ->where('status', 'active')
                ->orderBy('sold', 'desc')
                ->take(7)
                ->get();
        }

        return view('landing.index', compact('categories', 'productsByCategory'));
    }
}