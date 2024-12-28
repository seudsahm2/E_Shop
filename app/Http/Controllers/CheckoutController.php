<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\ISO3166\ISO3166;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItemCount = $this->calculateCartItemCount();
        $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();

        // Fetch the authenticated user's details and profile
        $user = Auth::user();
        $profile = $user->profile;

        $iso3166 = new ISO3166();
        $countries = $iso3166->all();

        // Extract country codes and names
        $countryList = [];
        foreach ($countries as $country) {
            $countryList[$country['alpha2']] = $country['name'];
        }

        return view('store.checkout', compact('cartItemCount', 'user', 'profile', 'countryList', 'cart'));
    }

    private function calculateCartItemCount()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        return $cart ? $cart->items->sum('quantity') : 0;
    }
}
