<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $cartItemCount = $this->getCartItemCount();
        return view('store.index', compact('products', 'cartItemCount'));
    }
}
