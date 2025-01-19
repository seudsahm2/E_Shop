<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $cartItemCount = $this->getCartItemCount();
        return view('store.product-detail', compact('product', 'cartItemCount'));
    }
}
