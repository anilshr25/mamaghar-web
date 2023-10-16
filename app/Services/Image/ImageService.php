<?php

namespace App\Services\Image;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;
use Intervention\Image\Facades\Image;
use App\Services\Traits\UploadPathTrait;
use Illuminate\Support\Facades\File as FacadesFile;

abstract class ImageService
{
    use UploadPathTrait;

    protected $uploadPath, $images;

    public function uploadFile($file, $uploadFor, $uploadName = null, $width = 320, $height = 320)
    {
        if (isset($file) && !empty($file)) {
            $uploadPath = $this->getUploadPath($uploadFor, $uploadName);
            $imageName = $this->uploadFileAndImages($file, $uploadPath, $width, $height);
            return $imageName;
        }
    }

    public function renameFile($uploadFor, $name, $newName)
    {
        try {
            $uploadPath = $this->getUploadPath($uploadFor, $name);
            $pattern = "/" . $name . "/";
            $newPath = preg_replace($pattern, $newName, $uploadPath);
            rename(public_path($uploadPath), public_path($newPath));
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function deleteUploaded($fileName, $uploadFor, $uploadName = null, $delete = false)
    {
        try {
            $uploadPath = $this->getUploadPath($uploadFor, $uploadName);
            $imageFullPath = $uploadPath . '/' . $fileName;
            $imageThumbFullPath = $uploadPath . '/thumb/' . $fileName;
            if (is_file($imageFullPath))
                unlink($imageFullPath);
            if (is_file($imageThumbFullPath))
                unlink($imageThumbFullPath);
            if (file_exists(public_path($uploadPath)) && $delete == true) {
                FacadesFile::deleteDirectory(public_path($uploadPath));
            }
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function uploadFileAndImages(UploadedFile $file, $uploadPath, $width = 320, $height = 320)
    {
        $fileName = $file->hashName();
        $file_type = $file->extension();
        $newFileName = sprintf("%s.%s", (sha1($fileName) . time()), $file_type);
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        if ($file->isValid()) {
            $file->move($uploadPath, $newFileName);
            $image = new File($uploadPath . '/' . $newFileName);
            if (substr($file->getClientMimeType(), 0, 5) == 'image' && $file_type != "ico") {
                $this->createThumb($image, $width, $height);
            }
            return $newFileName;
        } else {
            $file->move($uploadPath, $newFileName);
            return $newFileName;
        }
        return null;
    }

    public function createThumb(File $file, $width = 320, $height = 320)
    {
        try {
            $img = Image::make($file->getPathname());
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $path = sprintf('%s/thumb/%s', $file->getPath(), $file->getFilename());
            $directory = sprintf('%s/thumb', $file->getPath());
            if (!file_exists($directory)) {
                mkdir($directory, 0775, true);
            }
            $img->save($path);
        } catch (Exception $ex) {
            return null;
        }
    }
}
