<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'title'       => ['required','string','max:255'],
            'price'       => ['required','numeric','min:0'],
            'color'       => ['nullable','string','max:255'],
            'description' => ['nullable','string'],

            'photo1' => ['nullable','image','max:4096'],
            'photo2' => ['nullable','image','max:4096'],
            'photo3' => ['nullable','image','max:4096'],
            'photo4' => ['nullable','image','max:4096'],
            'photo5' => ['nullable','image','max:4096'],
            'photo6' => ['nullable','image','max:4096'],
        ]);

        // Upload photos
        for ($i = 1; $i <= 6; $i++) {
            $key = "photo{$i}";
            if ($request->hasFile($key)) {
                $data[$key] = $request->file($key)->store('products', 'public');
            }
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'title'       => ['required','string','max:255'],
            'price'       => ['required','numeric','min:0'],
            'color'       => ['nullable','string','max:255'],
            'description' => ['nullable','string'],

            'photo1' => ['nullable','image','max:20480'],
            'photo2' => ['nullable','image','max:20480'],
            'photo3' => ['nullable','image','max:20480'],
            'photo4' => ['nullable','image','max:20480'],
            'photo5' => ['nullable','image','max:20480'],
            'photo6' => ['nullable','image','max:20480'],
        ]);

        // Replace uploaded photos (delete old)
        for ($i = 1; $i <= 6; $i++) {
            $key = "photo{$i}";
            if ($request->hasFile($key)) {
                if ($product->$key) {
                    Storage::disk('public')->delete($product->$key);
                }
                $data[$key] = $request->file($key)->store('products', 'public');
            }
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated');
    }

    public function destroy(Product $product)
    {
        // delete photos
        for ($i = 1; $i <= 6; $i++) {
            $key = "photo{$i}";
            if ($product->$key) {
                Storage::disk('public')->delete($product->$key);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted');
    }
}
