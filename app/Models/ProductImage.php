<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image',
        'color_name',
        'color_hex',
        'is_main',
        'sort',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

