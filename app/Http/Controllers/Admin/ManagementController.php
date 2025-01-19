<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use Illuminate\Database\QueryException;

class ManagementController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $colors = Color::all();
        return view('admin.management.index', compact('categories', 'brands', 'colors'));
    }




    public function store(Request $request)
    {
        $messages = [
            'success' => [],
            'warning' => [],
        ];

        $request->validate([
            'category_name' => 'nullable|string|max:255',
            'brand_name' => 'nullable|string|max:255',
            'color_name' => 'nullable|array',
            'color_name.*' => 'nullable|string',
        ]);

        // Handle Categories
        if ($request->filled('category_name')) {
            $existingCategory = Category::where('name', $request->category_name)->first();
            if ($existingCategory) {
                $messages['warning'][] = "The category '{$request->category_name}' already exists in the database.";
            } else {
                Category::create(['name' => $request->category_name]);
                $messages['success'][] = "Category '{$request->category_name}' added successfully.";
            }
        } else {
            $messages['warning'][] = 'No category name provided.';
        }

        // Handle Brands
        if ($request->filled('brand_name')) {
            $existingBrand = Brand::where('name', $request->brand_name)->first();
            if ($existingBrand) {
                $messages['warning'][] = "The brand '{$request->brand_name}' already exists in the database.";
            } else {
                Brand::create(['name' => $request->brand_name]);
                $messages['success'][] = "Brand '{$request->brand_name}' added successfully.";
            }
        } else {
            $messages['warning'][] = 'No brand name provided.';
        }

        // Handle Colors
        if ($request->has('color_name') && is_array($request->color_name)) {
            foreach ($request->color_name as $color) {
                [$hex, $name] = explode(':', $color);
                $existingColor = Color::where('name', $name)->first();
                if ($existingColor) {
                    $messages['warning'][] = "The color '{$name}' already exists in the database.";
                } else {
                    Color::create(['name' => $name, 'hex_code' => $hex]);
                    $messages['success'][] = "Color '{$name}' added successfully.";
                }
            }
        } else {
            $messages['warning'][] = 'No colors were selected.';
        }

        // Store all messages in the session
        session()->flash('messages', $messages);

        // Redirect back with flash messages
        return redirect()->route('admin.management.index');
    }






    public function edit($type, $id)
    {
        $item = null;
        if ($type == 'category') {
            $item = Category::findOrFail($id);
        } elseif ($type == 'brand') {
            $item = Brand::findOrFail($id);
        } elseif ($type == 'color') {
            $item = Color::findOrFail($id);
        }

        return view('admin.management.edit', compact('item', 'type'));
    }

    public function update(Request $request, $type, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'hex_code' => 'nullable|string|max:7|unique:colors,hex_code,' . $id,
        ]);

        if ($type == 'category') {
            $item = Category::findOrFail($id);
        } elseif ($type == 'brand') {
            $item = Brand::findOrFail($id);
        } elseif ($type == 'color') {
            $item = Color::findOrFail($id);
        }

        $item->update([
            'name' => $request->name,
            'hex_code' => $request->hex_code,
        ]);

        return redirect()->route('admin.management.index')->with('success', ucfirst($type) . ' updated successfully.');
    }

    public function destroy($type, $id)
    {
        if ($type == 'category') {
            $item = Category::findOrFail($id);
        } elseif ($type == 'brand') {
            $item = Brand::findOrFail($id);
        } elseif ($type == 'color') {
            $item = Color::findOrFail($id);
        }

        $item->delete();

        return redirect()->route('admin.management.index')->with('success', ucfirst($type) . ' deleted successfully.');
    }
}
