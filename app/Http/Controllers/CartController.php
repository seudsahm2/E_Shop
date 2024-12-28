<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Check if the requested quantity is available
        $requestedQuantity = $request->input('quantity', 1);

        // Retrieve or create the cart for the authenticated user
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        // Get the cart item or create a new one
        $cartItem = CartItem::firstOrNew(['cart_id' => $cart->id, 'product_id' => $id]);

        // Calculate the new quantity
        $newQuantity = $cartItem->quantity + $requestedQuantity;

        // Ensure the new quantity does not exceed the product's stock
        if ($newQuantity > $product->quantity) {
            return response()->json(['error' => 'Requested quantity exceeds available stock.'], 400);
        }

        // Update cart item quantity
        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        // Calculate delivery fee based on total quantity
        $totalQuantity = $cart->items->sum('quantity');
        $deliveryFee = $this->calculateDeliveryFee($totalQuantity);
        $cart->delivery_fee = $deliveryFee;
        $cart->save();

        // Return the updated cart item count
        $cartItemCount = $this->getCartItemCount();
        return response()->json(['cartItemCount' => $cartItemCount, 'success' => 'Product added to cart successfully!']);
    }

    public function updateQuantity(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart not found.']);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $id)->first();

        if ($cartItem) {
            $product = $cartItem->product;

            if ($validated['quantity'] <= $product->quantity) {
                $cartItem->quantity = $validated['quantity'];
                $cartItem->save();

                $subtotal = $cart->items->sum(function ($item) {
                    return $item->quantity * $item->product->price;
                });

                $newTotal = $subtotal + $cart->delivery_fee;

                return response()->json([
                    'success' => true,
                    'message' => 'Quantity updated successfully.',
                    'subtotal' => $subtotal,
                    'deliveryFee' => $cart->delivery_fee,
                    'newTotal' => $newTotal,
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Insufficient stock for this product.']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Cart item not found.']);
    }




    public function removeItem($id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $id)->first();
            if ($cartItem) {
                $cartItem->delete();
            }
        }

        return redirect()->route('cart.view')->with('success', 'Item removed from the cart.');
    }





    public function clearCart()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->items()->delete();
            $cart->delivery_fee = 0; // Reset the delivery fee
            $cart->save();
        }

        return redirect()->route('cart.view');
    }

    public function viewCart()
    {
        $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();
        $cartItemCount = $this->getCartItemCount();
        return view('store.cart', compact('cart', 'cartItemCount'));
    }

    private function calculateDeliveryFee($totalQuantity)
    {
        $baseFee = 5.00; // Base delivery fee
        $additionalFee = 2.00; // Additional fee per item over the base quantity
        $baseQuantity = 5; // Base quantity for the base fee

        if ($totalQuantity <= $baseQuantity) {
            return $baseFee;
        }

        return $baseFee + ($totalQuantity - $baseQuantity) * $additionalFee;
    }
}
