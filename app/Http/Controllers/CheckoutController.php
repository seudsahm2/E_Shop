<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use League\ISO3166\ISO3166;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Sale;
use App\Events\OrderPlaced;
use App\Events\LowStockNotification;
use App\Models\Notification;

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
                'status' => 'pending',
            ]);

            $orderItems = [];
            foreach ($cart->items as $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
                $orderItems[] = $orderItem;
            }

            // Display order items using dd()

            // Create a Sale record
            Sale::create([
                'order_id' => $order->id,
                'amount' => $order->total,
            ]);

            // Trigger the event
            event(new OrderPlaced($order));

            foreach ($cart->items as $item) {
                $product = $item->product;
                $product->quantity -= $item->quantity;
                $product->save();

                if ($product->quantity < 3) {
                    // Trigger the LowStockNotification event
                    event(new LowStockNotification($product));
                }else {
                    // Mark the low stock notification as read or delete it if the quantity is above the threshold
                    Notification::where('product_id', $product->id)
                        ->where('type', 'low_stock')
                        ->update(['is_read' => true]);
                }
            }


            // Clear the cart
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            return redirect()->route('checkout.success')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error placing order:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'There was an error placing your order.');
        }
    }

    public function success()
    {
        $cartItemCount = $this->getCartItemCount();
        return view('store.checkout_success', compact('cartItemCount'));
    }
}
