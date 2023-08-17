<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Model\Media;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
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

    /**
     * Download asset from url
     * 
     * @param string $url 
     * @return array<string, mixed>
     */

    public static function downloadAsset(string $url): array
    {
        try {
            $response = Http::get($url);

            if ($response->status() === 200) {
                $filename = basename(parse_url($url, PHP_URL_PATH));
                $contentType = $response->header('content-type');
                $fileContent = $response->body();

                return [
                    'filename' => $filename,
                    'content-type' => $contentType,
                    'content' => $fileContent,
                ];
            } else {
                throw new \Exception('Error downloading file');
            }
        } catch (\Throwable $th) {
            return ['error' => $th->getMessage()];
        }
    }
}
