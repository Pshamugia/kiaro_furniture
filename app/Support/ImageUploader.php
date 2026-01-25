<?php

namespace App\Support;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class ImageUploader
{
     public static function upload(UploadedFile $file, string $folder): string
    {
        $filename = Str::uuid() . '.webp';

        $manager = new ImageManager(new Driver());

        $image = $manager
            ->read($file)
            ->scaleDown(1600, 1600)
            ->toWebp(85);

        $path = "{$folder}/{$filename}";

        Storage::disk('public')->put($path, (string) $image);

        return $path;
    }
}
