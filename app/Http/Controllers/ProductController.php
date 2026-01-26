<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function index(Request $request, $slug = null)
    {
        $category = null;

        if ($slug) {
            $category = Category::where('slug', $slug)->firstOrFail();
        }

        $products = Product::query()->with('category');

        if ($category) {

            // SUBCATEGORY → only its products
            if ($category->parent_id) {
                $products->where('category_id', $category->id);
            }
            // PARENT CATEGORY → all its subcategories
            else {
                $subCategoryIds = Category::where('parent_id', $category->id)
                    ->pluck('id');

                $products->whereIn('category_id', $subCategoryIds);
            }
        }

        return view('products.index', [
            'products' => $products->latest()->paginate(12),
            'currentCategory' => $category,
        ]);
    }

    

    public function showBySlug(string $slug)
{
    $product = Product::where('slug', $slug)->firstOrFail();
    return view('product-full', compact('product'));
}
}
