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
        $cartItemCount = $this->getCartItemCount();

        $products = Product::query();

        // Calculate the minimum and maximum prices
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        if ($request->has('category')) {
            $products->where('category_id', $request->category);
        }

        if ($request->has('brands')) {
            $products->whereIn('brand_id', $request->brands);
        }
        if ($request->has('colors')) {
            $products->whereHas('colors', function ($query) use ($request) {
                $query->whereIn('colors.id', $request->colors);
            });
        }

        if ($request->has('price_min') && $request->has('price_max')) {
            $products->whereBetween('price', [$request->price_min, $request->price_max]);
        }

        $products = $products->paginate(12);

        return view('store.shop', compact('products', 'categories', 'brands', 'colors', 'cartItemCount', 'minPrice', 'maxPrice'));
    }
}
