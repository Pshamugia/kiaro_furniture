<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ProductImageController extends Controller
{
public function destroy(ProductImage $product_image)
{
    if ($product_image->is_main) {
        $next = ProductImage::where('product_id', $product_image->product_id)
            ->where('id', '!=', $product_image->id)
            ->first();

        if ($next) {
            $next->update(['is_main' => 1]);
        }
    }

    Storage::disk('public')->delete($product_image->image);
    $product_image->delete();

    return back();
}



}
