<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageUploader
{
    public static function upload(UploadedFile $file, string $folder): string
    {
        $filename = Str::uuid() . '.webp';

        $path = storage_path("app/public/{$folder}/{$filename}");

        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $manager = new ImageManager(new Driver());

        $image = $manager->read($file);

        $image
            ->scaleDown(1600, 1600)   // keeps aspect ratio, prevents upscaling
            ->toWebp(85)              // convert to webp, quality 85
            ->save($path);

        return "{$folder}/{$filename}";
    }
}
