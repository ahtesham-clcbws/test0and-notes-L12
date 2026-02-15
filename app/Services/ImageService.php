<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    protected $manager;

    public function __construct()
    {
        // Use GD driver
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * optimizing uploaded image
     *
     * @param mixed $file The uploaded file instance or file path
     * @param string $path Storage path (folder)
     * @param int $maxWidth Maximum width (default 1024px)
     * @param int $quality Quality (0-100, default 80)
     * @return string The stored file path
     */
    public function handleUpload($file, $path, $maxWidth = 1024, $quality = 80)
    {
        // Check if file is an image
        $isImage = false;
        if ($file instanceof \Illuminate\Http\UploadedFile) {
            $mime = $file->getMimeType();
            $isImage = str_starts_with($mime, 'image/');
        } else {
             // Fallback if it's a path or other object, though primarily used with UploadedFile
             $isImage = @is_array(getimagesize($file));
        }

        if (!$isImage) {
             // Just store the file as is
             $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
             $file->storeAs($path, $filename, 'public');
             return $path . '/' . $filename;
        }

        // Create image instance
        $image = $this->manager->read($file);

        // Resize if width exceeds maxWidth, maintaining aspect ratio
        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        // Encode to WebP
        $encoded = $image->toWebp($quality);

        // Generate unique filename
        $filename = Str::uuid() . '.webp';
        $fullPath = $path . '/' . $filename;

        // Save to public storage
        Storage::disk('public')->put($fullPath, (string) $encoded);

        return $fullPath;
    }

    /**
     * Converting existing image to webp and resize
     *
     * @param string $existingPath Relative path in public disk
     * @param int $maxWidth
     * @param int $quality
     * @return string|null New path or null if processing failed
     */
    public function optimizeExisting($existingPath, $maxWidth = 1024, $quality = 80)
    {
        if (!Storage::disk('public')->exists($existingPath)) {
            return null;
        }

        $absolutePath = Storage::disk('public')->path($existingPath);
        $mime = mime_content_type($absolutePath);
        if (!str_starts_with($mime, 'image/')) {
            return null;
        }

        $fileContent = Storage::disk('public')->get($existingPath);
        $image = $this->manager->read($fileContent);

        // Resize
        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        // Encode to WebP
        $encoded = $image->toWebp($quality);

        // Generate new path with .webp extension
        $pathInfo = pathinfo($existingPath);
        $newFilename = $pathInfo['filename'] . '.webp';

        // Keep same directory
        $newPath = ($pathInfo['dirname'] === '.' ? '' : $pathInfo['dirname'] . '/') . $newFilename;

        // Save new file
        Storage::disk('public')->put($newPath, (string) $encoded);

        return $newPath;
    }
}
