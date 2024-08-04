<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ImageHelper
{
    public static function saveImage($file, $path)
    {
        // $image = $file;
        // $extension = $image->getClientOriginalExtension();
        // $fileName = rand(111111, 9999999) . '.' . $extension;
        // $imagePath = $image->storeAs($path, $fileName);

        // return $imagePath;

        $manager = new ImageManager(new Driver());
        $base64Image = str_replace('data:base64Image/jpg;base64,', '', $file);
        $base64Image = str_replace(' ', '+', $base64Image);

        $imageName = Str::random(10) . '_' . date('YmdHis') . '.' . 'jpg';

        $image = $manager->read(base64_decode($base64Image));
        $image->encode(new AutoEncoder(quality: 60));
        $image->save(public_path($path . $imageName));

        return $path . $imageName;  // uploads/brand/imageName.jpg
    }

    public static function removeImage($file)
    {
        // Storage::disk('public')->delete($path, $file);
        unlink(public_path($file));
    }
}
