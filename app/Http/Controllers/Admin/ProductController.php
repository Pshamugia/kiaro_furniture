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
            'category_id' => ['required', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],

            'images'              => ['required', 'array', 'min:1'],
            'images.*.file'       => ['required', 'image', 'max:20480'],
            'images.*.color_name' => ['nullable', 'string', 'max:50'],
            'images.*.color_hex'  => ['nullable', 'string', 'max:7'],
        ]);

        $mainIndex = $request->input('main_image_index');

        $product = Product::create([
            'category_id' => $data['category_id'],
            'title'       => $data['title'],
            'price'       => $data['price'],
            'description' => $data['description'] ?? null,
        ]);

        foreach ($request->images as $index => $img) {

            $path = ImageUploader::upload($img['file'], 'products');

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
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],

            'images'                  => ['nullable', 'array'],
            'images.*.file'           => ['nullable', 'image', 'max:20480'],
            'images.*.color_name'     => ['nullable', 'string', 'max:50'],
            'images.*.color_hex'      => ['nullable', 'string', 'max:7'],
            'images.*.is_main'        => ['nullable', 'boolean'],
        ]);

        $mainIndex = $request->input('main_image_index');

        // update product
        $product->update([
            'category_id' => $data['category_id'],
            'title'       => $data['title'],
            'price'       => $data['price'],
            'description' => $data['description'] ?? null,
        ]);

        if ($request->images) {

            // reset main flags
            $product->images()->update(['is_main' => 0]);

            foreach ($request->images as $index => $img) {

                // =========================
                // EXISTING IMAGE
                // =========================
                if (isset($img['id'])) {

                    $image = $product->images()->find($img['id']);
                    if (!$image) continue;

                    // replace file if uploaded
                    if (isset($img['file'])) {
                        Storage::disk('public')->delete($image->image);

                        $image->image = ImageUploader::upload(
                            $img['file'],
                            'products'
                        );
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
                    $path = ImageUploader::upload(
                        $img['file'],
                        'products'
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


        return redirect()
            ->route('admin.products.index')
            ->with('success', 'პროდუქტი წარმატებით განახლდა');
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
