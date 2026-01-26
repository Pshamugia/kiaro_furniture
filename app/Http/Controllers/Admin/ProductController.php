<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Support\ImageUploader;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = trim($request->q);

        $products = Product::with('category')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhereHas('category', function ($c) use ($q) {
                            $c->where('name', 'like', "%{$q}%");
                        });
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'q'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        return view('admin.products.create', compact('categories'));
    }


    public function store(Request $request)
{
    $data = $request->validate([
        'category_id' => ['required', 'exists:categories,id'],
        'title'       => ['required', 'string', 'max:255'],
        'price'       => ['required', 'numeric', 'min:0'],
        'discount'    => ['nullable', 'numeric', 'min:0', 'lt:price'],
        'description' => ['nullable', 'string'],
        'watermark'   => ['nullable', 'boolean'],

        'images'              => ['required', 'array', 'min:1'],
        'images.*.file'       => ['required', 'image', 'max:20480'],
        'images.*.color_name' => ['nullable', 'string', 'max:50'],
        'images.*.color_hex'  => ['nullable', 'string', 'max:7'],
    ]);

    $mainIndex = $request->input('main_image_index');

    // ✅ CREATE PRODUCT FIRST
    $product = Product::create([
        'category_id' => $data['category_id'],
        'title'       => $data['title'],
        'price'       => $data['price'],
        'discount'    => $data['discount'] ?? null,
        'description' => $data['description'] ?? null,
        'watermark'   => $request->has('watermark'), // ✅ IMPORTANT
    ]);

    // ✅ UPLOAD IMAGES WITH FLAG
    foreach ($request->images as $index => $img) {

        $path = ImageUploader::upload(
            $img['file'],
            'products',
            $product->watermark // ✅ PASS FLAG
        );

        $product->images()->create([
            'image'      => $path,
            'color_name' => $img['color_name'] ?? null,
            'color_hex'  => $img['color_hex'] ?? null,
            'is_main'    => ($index == $mainIndex),
        ]);
    }

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Product created successfully');
}





    public function edit(Product $product)
    {
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }


    public function update(Request $request, Product $product)
{
    $data = $request->validate([
        'category_id' => ['required', 'exists:categories,id'],
        'title'       => ['required', 'string', 'max:255'],
        'price'       => ['required', 'numeric', 'min:0'],
        'discount'    => ['nullable', 'numeric', 'min:0', 'lt:price'],
        'description' => ['nullable', 'string'],
        'watermark'   => ['nullable', 'boolean'],

        'images'              => ['nullable', 'array'],
        'images.*.file'       => ['nullable', 'image', 'max:20480'],
        'images.*.color_name' => ['nullable', 'string', 'max:50'],
        'images.*.color_hex'  => ['nullable', 'string', 'max:7'],
    ]);

    $mainIndex = $request->input('main_image_index');

    // ✅ UPDATE PRODUCT FIRST (CRITICAL)
    $product->update([
        'category_id' => $data['category_id'],
        'title'       => $data['title'],
        'price'       => $data['price'],
        'discount'    => $data['discount'] ?? null,
        'description' => $data['description'] ?? null,
        'watermark'   => $request->has('watermark'), // ✅ UPDATED VALUE
    ]);

    if ($request->images) {

        // reset main flags
        $product->images()->update(['is_main' => 0]);

        foreach ($request->images as $index => $img) {

    // =========================
    // DELETE IMAGE (⬅️ PLACE IT HERE)
    // =========================
    if (!empty($img['_delete']) && isset($img['id'])) {

        $image = $product->images()->find($img['id']);

        if ($image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        continue; // ⛔ skip further processing for this image
    }

    // =========================
    // EXISTING IMAGE
    // =========================
    if (isset($img['id'])) {

        $image = $product->images()->find($img['id']);
        if (!$image) continue;

        if (
            isset($img['file']) &&
            $img['file'] instanceof \Illuminate\Http\UploadedFile
        ) {
            $newPath = ImageUploader::upload(
                $img['file'],
                'products',
                $product->watermark
            );

            Storage::disk('public')->delete($image->image);
            $image->image = $newPath;
        }

        $image->update([
            'color_name' => $img['color_name'] ?? null,
            'color_hex'  => $img['color_hex'] ?? null,
            'is_main'    => ($index == $mainIndex),
        ]);

    } else {

        // =========================
        // NEW IMAGE
        // =========================
        if (
            isset($img['file']) &&
            $img['file'] instanceof \Illuminate\Http\UploadedFile
        ) {
            $path = ImageUploader::upload(
                $img['file'],
                'products',
                $product->watermark
            );

            $product->images()->create([
                'image'      => $path,
                'color_name' => $img['color_name'] ?? null,
                'color_hex'  => $img['color_hex'] ?? null,
                'is_main'    => ($index == $mainIndex),
            ]);
        }
    }
}

    }

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'პროდუქტი წარმატებით განახლდა');
}






    public function destroy(Product $product)
    {
        // delete related images (NEW SYSTEM)
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted');
    }
}
