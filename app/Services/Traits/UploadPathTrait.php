<?php

namespace App\Services\Traits;

trait UploadPathTrait
{
    protected $folderPath = 'uploads/';

    public function getUploadPath($folder, $name = null)
    {
        $folderPath = $this->folderPath;
        $name = preg_replace('/[\*\^\#\!\`\~\$\%\{\}\'\:\/\\\_\@\.\;\&\(\)" "]+/', '-', strtolower($name));
        if($name) {
            $path = $folderPath . $folder . '/' . $name;
        } else {
            $path = $folderPath . $folder;
        }
        return $path;
    }
}
