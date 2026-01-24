<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = [
    'category_id',
    'title',
    'price',
    'color',
    'description',
    'photo1',
    'photo2',
    'photo3',
    'photo4',
    'photo5',
    'photo6',
];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
{
    return $this->hasMany(ProductImage::class);
}

public function mainImage()
{
    return $this->hasOne(ProductImage::class)->where('is_main', true);
}

}

