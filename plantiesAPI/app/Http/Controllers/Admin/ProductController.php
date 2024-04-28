<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->get();
        return view('admin.dashboard', compact('products'));
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'category_name' => 'required|string|max:255'
        ]);

        $product = Product::findOrFail($request->product_id);
        $category = Category::firstOrCreate(['name' => $request->category_name]);
        $product->categories()->attach($category->id);

        return redirect()->route('admin.dashboard')->with('success', 'Category added successfully!');
    }

    public function removeCategory(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id'
        ]);

        $product = Product::findOrFail($id);
        $product->categories()->detach($request->category_id);

        return redirect()->route('admin.dashboard')->with('success', 'Category removed successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_path) {
            Storage::delete('public/' . $product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Product deleted successfully.');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'care_level' => 'required|integer',
            'stock_quantity' => 'required|integer',
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('image')->store('Product_images', 'public');

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'care_level' => $request->care_level,
            'stock_quantity' => $request->stock_quantity,
            'image_path' => $imagePath,
            'info' => $request->info,
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'care_level' => 'required|integer',
            'stock_quantity' => 'required|integer',
            'image' => 'image|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $data = $request->only(['name', 'price', 'care_level', 'stock_quantity', 'info']);

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::delete('public/' . $product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('Product_images', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.dashboard');
    }

    public function edit($id)
    {
        $product = Product::with('categories')->findOrFail($id);
        return view('admin.edit_product', compact('product'));
    }

}
