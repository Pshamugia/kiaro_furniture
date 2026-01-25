<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::query();
    $currentCategory = null;

    if ($request->category) {
        $currentCategory = Category::with('parent')->find($request->category);

        if ($currentCategory) {
            $query->where('category_id', $currentCategory->id);
        }
    }

    if ($request->q) {
        $query->where('name', 'like', '%'.$request->q.'%');
    }

    $products = $query->paginate(12);

    return view('products.index', compact('products', 'currentCategory'));
}

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
