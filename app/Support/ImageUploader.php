<?php

namespace App\Support;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class ImageUploader
{
    public static function upload(
        UploadedFile $file,
        string $folder,
        bool $useWatermark
    ): string {
        if (!$file->isValid()) {
            throw new \Exception('Invalid image upload');
        }

        $manager = new ImageManager(new Driver());
        $filename = Str::uuid() . '.webp';

        // MAIN IMAGE
        $image = $manager
            ->read($file)
            ->scaleDown(1600, 1600);

        // ===============================
        // IMAGE WATERMARK (OPTIONAL)
        // ===============================
        $watermarkPath = public_path('images/watermark.png');

        if ($useWatermark && file_exists($watermarkPath)) {

            $watermark = $manager->read($watermarkPath);

            $targetWidth = intval($image->width() * 0.15);
            $watermark->scaleDown($targetWidth);

            $image->place(
                $watermark,
                'top-left',
                80,
                40,
                70
            );
        }

        // SAVE
        $path = "{$folder}/{$filename}";
        Storage::disk('public')->put(
            $path,
            (string) $image->toWebp(85)
        );

        return $path;
    }
}
