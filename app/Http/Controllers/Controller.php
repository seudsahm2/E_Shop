<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected function getCartItemCount()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        return $cart ? $cart->items->sum('quantity') : 0;
    }
}
