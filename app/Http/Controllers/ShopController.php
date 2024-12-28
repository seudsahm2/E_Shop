<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $cartItemCount = $this->getCartItemCount();
        return view('store.shop',compact('cartItemCount'));
    }
}
