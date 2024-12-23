<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Retrieve existing cart from session or initialize an empty one
        $cart = session()->get('cart', []);

        // Add or update the product in the cart
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->input('quantity', 1);
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->input('quantity', 1),
                'image' => $product->image // Add an image field if applicable
            ];
        }

        // Save the cart back to session
        session()->put('cart', $cart);

        return redirect()->route('product.show', $id)->with('success', 'Product added to cart successfully!');
    }

    public function viewCart()
    {
        // Retrieve the cart from session
        $cart = session()->get('cart', []);

        return view('store.cart', compact('cart'));
    }
}
