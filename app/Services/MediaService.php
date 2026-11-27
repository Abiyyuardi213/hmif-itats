<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    public function storeImage(UploadedFile $file, string $directory, int $maxWidth = 1400): string
    {
        $filename = Str::uuid()->toString().'.jpg';
        $relativePath = trim($directory, '/').'/'.$filename;

        $image = @imagecreatefromstring((string) file_get_contents($file->getRealPath()));
        if ($image !== false) {
            $width = imagesx($image);
            $height = imagesy($image);

            if ($width > $maxWidth) {
                $newHeight = (int) round($height * ($maxWidth / $width));
                $resized = imagecreatetruecolor($maxWidth, $newHeight);
                $white = imagecolorallocate($resized, 255, 255, 255);
                imagefill($resized, 0, 0, $white);
                imagecopyresampled($resized, $image, 0, 0, 0, 0, $maxWidth, $newHeight, $width, $height);
                imagedestroy($image);
                $image = $resized;
            }

            ob_start();
            imageinterlace($image, true);
            imagejpeg($image, null, 82);
            $binary = (string) ob_get_clean();
            imagedestroy($image);

            Storage::disk('public')->put($relativePath, $binary);

            return $relativePath;
        }

        return $file->store($directory, 'public');
    }

    public function deleteIfManaged(?string $path): void
    {
        if (! $path || str_starts_with($path, 'image/')) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
