<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\ISO3166\ISO3166;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Sale;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('shop')->with('error', 'Your cart is empty. Please add items to your cart before proceeding to checkout.');
        }

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

    public function processCheckout(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'zipcode' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'payment_method' => 'required|string|in:cod,paypal',
        ]);

        DB::beginTransaction();

        try {
            $cart = Cart::where('user_id', Auth::id())->firstOrFail();

            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $cart->items->sum(function ($item) {
                    return $item->product->price * $item->quantity;
                }) + $cart->delivery_fee,
                'payment_method' => $request->payment_method,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }
            // Create a Sale record
            Sale::create([
                'order_id' => $order->id,
                'amount' => $order->total,
            ]);

            // Clear the cart
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            return redirect()->route('checkout.success')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'There was an error processing your order. Please try again.');
        }
    }

    public function success()
    {
        $cartItemCount = $this->getCartItemCount();
        return view('store.checkout_success', compact('cartItemCount'));
    }
}
