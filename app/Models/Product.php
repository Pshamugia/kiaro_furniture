<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Product extends Model
{
   protected $fillable = [
    'category_id',
    'title',
    'price',
    'discount',
    'slug',
    'color',
    'description',
    'watermark',
    'photo1',
    'photo2',
    'photo3',
    'photo4',
    'photo5',
    'photo6',
];




protected $casts = [
    'price'    => 'decimal:2',
    'discount' => 'decimal:2',
];

public function hasDiscount(): bool
{
    return $this->discount !== null && $this->discount > 0 && $this->discount < $this->price;
}

public function finalPrice(): float
{
    return $this->hasDiscount()
        ? (float) $this->discount
        : (float) $this->price;
}


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

 

public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Auto-generate slug on create/update
     */
   protected static function booted()
{
    static::saving(function ($product) {
        if (empty($product->slug)) {
            $product->slug = Str::slug($product->title) . '-' . $product->id;
        }
    });
}

    /**
     * Generate UNIQUE slug with Georgian → Latin support
     */
    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = static::slugifyKa($title);
        $slug = $baseSlug;

        $i = 1;
        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$i}";
            $i++;
        }

        return $slug;
    }

    /**
     * Georgian → Latin transliteration
     */
    protected static function slugifyKa(string $text): string
    {
        $map = [
            'ა'=>'a','ბ'=>'b','გ'=>'g','დ'=>'d','ე'=>'e','ვ'=>'v','ზ'=>'z','თ'=>'t','ი'=>'i','კ'=>'k','ლ'=>'l',
            'მ'=>'m','ნ'=>'n','ო'=>'o','პ'=>'p','ჟ'=>'zh','რ'=>'r','ს'=>'s','ტ'=>'t','უ'=>'u','ფ'=>'f',
            'ქ'=>'k','ღ'=>'gh','ყ'=>'q','შ'=>'sh','ჩ'=>'ch','ც'=>'ts','ძ'=>'dz','წ'=>'ts','ჭ'=>'ch',
            'ხ'=>'kh','ჯ'=>'j','ჰ'=>'h'
        ];

        $text = mb_strtolower($text);
        $text = strtr($text, $map);
        $text = preg_replace('/[^a-z0-9]+/u', '-', $text);
        $text = trim($text, '-');

        return $text ?: 'product';
    }

}

