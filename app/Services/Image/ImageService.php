<?php

namespace App\Services\Image;

use App\Services\Traits\AmazonS3;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File as FacadesFile;

abstract class ImageService
{
    use AmazonS3;

    protected $uploadPath, $images;

    public function uploadFile($file, $uploadFor, $uploadName = null, $visibility = 'public', $width = 320, $height = 320)
    {
        if (isset($file) && !empty($file)) {
            $uploadPath = getUploadPath($uploadFor, $uploadName);
            $imageName = $this->uploadFileAndImages($file, $uploadPath, $visibility, $width, $height);
            return $imageName;
        }
    }

    public function renameFile($uploadFor, $name, $newName)
    {
        try {
            $uploadPath = getUploadPath($uploadFor, $name);
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
            $uploadPath = getUploadPath($uploadFor, $uploadName);
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

    public function uploadFileAndImages(UploadedFile $file, $uploadPath, $visibility, $width = 320, $height = 320)
    {
        $imageType = ['jpeg', 'jpg', 'png', 'JPEG', 'JPG'];

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $isImage = true;
        $fileName = $file->hashName();
        $file_type = $file->extension();
        $newFileName = sprintf("%s.%s", (sha1($fileName) . time()), $file_type);

        if (!empty($fName))
            $newFileName = $fName . "." . $file_type;
        if (!in_array($file_type, $imageType)) {
            $isImage = false;
        }

        if ($isImage) {
            if ($file->isValid()) {
                $file->move($uploadPath, $newFileName);
                $image = new File($uploadPath . '/' . $newFileName);
                if (substr($file->getClientMimeType(), 0, 5) == 'image') {
                    $this->createThumb($image, $width, $height);
                }

                if (getStorageType() != 'local') {
                    $this->uploadToS3($uploadPath, $newFileName, $isImage, $visibility);
                }
                return $newFileName;
            }
        } else {
            $file->move($uploadPath, $newFileName);
            if (getStorageType() != 'local') {
                $this->uploadToS3($uploadPath, $newFileName, $isImage, $visibility);
            }
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
