<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private function checkAdmin()
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect('/home');
        }
    }
    public function create()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $categories = Category::all();
        $brands = Brand::all();
        $colors = Color::all();

        return view('admin.products.create', compact('categories', 'brands', 'colors'));
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'required|image',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'colors' => 'required|array',
            'colors.*' => 'exists:colors,id', // Validate that color IDs exist in the colors table
        ]);

        // Store the product image
        $imagePath = $request->file('image')->store('products', 'public');

        // Create the product in the database
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'cost' => $request->cost,
            'quantity' => $request->quantity,
            'image' => $imagePath,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
        ]);

        // Attach selected colors to the product
        $product->colors()->attach($request->colors); // Attach the selected color IDs directly

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
    }

    public function edit(Product $product)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $categories = Category::all();
        $brands = Brand::all();
        $colors = Color::all();

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'colors'));
    }

    public function update(Request $request, Product $product)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'cost' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'nullable|image',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'colors' => 'required|array',
            'colors.*' => 'required|string|max:7', // Validate hex color codes
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->update(['image' => $imagePath]);
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
        ]);

        // Sync colors
        $product->colors()->sync($request->colors);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }


    public function index()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }
}
