<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService
{   

    /**
     * Upload image to cloudinary
     * 
     * @param UploadedFile $file
     * @param string $folder
     * 
     * @return string
     */
    public static function uploadImage(UploadedFile $file, string $folder = 'images'): string
    {
        $image = cloudinary()->upload($file->getRealPath(), [
            'folder' => $folder,
            'resource_type' => 'image',
        ])->getSecurePath();

        return $image;
    }

    /**
     * Upload video to cloudinary
     * 
     * @param UploadedFile $file
     * @param string $folder
     * 
     * @return string
     */

    public static function uploadAudio(UploadedFile $file, string $folder = 'beats'): string
    {
        $video = cloudinary()->upload($file->getRealPath(), [
            'folder' => $folder,
            'resource_type' => 'video',
        ])->getSecurePath();

        return $video;
    }
}
