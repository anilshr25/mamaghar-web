<?php

namespace App\Services\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait AmazonS3
{
    protected $disk = "wasabi";

    public function uploadToS3($uploadPath, $fileName, $isImage, $visibility)
    {
        setStorageConfig();
        $storageType = getStorageType();
        $s3 = Storage::disk($storageType);

        $realPath = $uploadPath . "/" . $fileName;
        $thumbPath = null;
        if ($isImage) {
            $thumbPath = $uploadPath . "/thumb/" . $fileName;
        }

        $this->createFolder($uploadPath);

        if (!empty($realPath) && is_file($realPath)) {
            $s3->put($realPath, File::get($realPath), $visibility);
        }
        if (!empty($thumbPath) && is_file($thumbPath)) {
            $s3->put($thumbPath, File::get($thumbPath), $visibility);
        }

        if (is_file($realPath))
            File::delete($realPath);

        if (is_file($thumbPath))
            File::delete($thumbPath);

        return $s3->url($realPath);
    }

    public function createFolder($path)
    {
        $s3 = Storage::disk($this->disk);
        if (!$s3->exists($path)) {
            return $s3->makeDirectory($path);
        }
        return null;
    }

    public function deleteFromS3($uploadPath, $imageName)
    {
        setStorageConfig();
        $storageType = getStorageType();
        $s3 = Storage::disk($storageType);
        $path = [];
        $parentPath = $uploadPath . '/' . $imageName;
        $thumbPath = $uploadPath . '/thumb/' . $imageName;
        if (!empty($parentPath)) {
            array_push($path, $parentPath);
        }

        if (!empty($parentPath)) {
            array_push($path, $thumbPath);
        }
        if (sizeof($path) > 0) {
            $s3->delete($path);
        }
        return true;
    }

    public function createThumbS3($file, $width = 320, $height = 320)
    {
        $imageFile = Image::make($file)->resize($width, $height)->stream();
        $imageFile = $imageFile->__toString();
        return $imageFile;
    }

    public function deleteFileFromS3($path)
    {
        setStorageConfig();
        $storageType = getStorageType();
        $s3 = Storage::disk($storageType);
        $parentPath = $path . '/' . $path;
        if ($s3->exists($parentPath)) {
            return $s3->readAndDelete($parentPath);
        }
    }
}
