<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $colors = Color::all();

        $products = Product::query();
        $cartItemCount = $this->getCartItemCount();

        if ($request->has('category')) {
            $products->where('category_id', $request->category);
        }

        if ($request->has('brand')) {
            $products->where('brand_id', $request->brand);
        }

        if ($request->has('colors')) {
            $products->whereHas('colors', function ($query) use ($request) {
                $query->whereIn('id', $request->colors);
            });
        }

        if ($request->has('price')) {
            $products->where('price', '<=', $request->price);
        }

        $products = $products->paginate(12);

        return view('store.shop', compact('products', 'categories', 'brands', 'colors', 'cartItemCount'));
    }
}
