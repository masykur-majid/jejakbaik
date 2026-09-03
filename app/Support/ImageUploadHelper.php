<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;

class ImageUploadHelper
{
    public static function convertAndStore(
        UploadedFile $file,
        string $directory = 'uploads',
        string $disk = 'r2',
        int $quality = 80,
        ?int $maxWidth = 1200
    ): string {
        $filename = $directory . '/' . Str::uuid() . '.webp';

        $manager = ImageManager::usingDriver(Driver::class);
        $image = $manager->decode($file->get());

        if ($maxWidth !== null && $image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $encoded = $image->encodeUsingFormat(Format::WEBP, quality: $quality);

        Storage::disk($disk)->put($filename, (string) $encoded);

        return $filename;
    }
}
