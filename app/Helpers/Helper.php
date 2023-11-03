<?php

use App\Models\EmailTemplate\EmailTemplate;
use App\Models\SiteSetting\SiteSetting;
use Hashids\Hashids;
use Illuminate\Support\Str;


function getEmailTemplate($role, $type)
{
    if (empty($template))
        $template = EmailTemplate::whereRole($role)->whereType($type)->whereIsActive(1)->first();

    return $template;
}

function getEmailRawTag($tag)
{
    return config('email-template.tags.' . $tag);
}

function renderEmailHTML($description, $acceptedTags)
{
    if (!empty($acceptedTags)) {
        foreach ($acceptedTags as $tag) {
            $pattern = "/{!-" . $tag . "-!}/i";
            $description = preg_replace($pattern, getEmailRawTag($tag), $description);
        }
    }
    return $description;
}

function renderEmailData($description, $accepted_inputs, $data)
{
    if (!empty($accepted_inputs)) {
        foreach ($accepted_inputs as $input) {
            $pattern = "/{{" . $input . "}}/i";
            $description = preg_replace($pattern, $data[$input], $description);
        }
    }
    return $description;
}

function renderLoopData($description, $loopData)
{
    if (!empty($loopData)) {
        foreach ($loopData as $key => $loop) {
            $html = '';
            $loopNumber = $key + 1;
            $pattern = '{--loop--' . $loopNumber . '}';
            if (Str::contains($description, $pattern)) {

                foreach ($loop as $ind => $data) {
                    $html .= '<ul>';
                    foreach ($data as $index => $info) {
                        $html .= '<li><b>' . ucfirst(str_replace('_', ' ', $index)) . ': </b>' . $info . '</li>';
                    }
                    $html .= '</ul><hr>';
                }

                $description = str_replace($pattern, $html, $description);
            }
        }
    }

    return $description;
}

function buildTableNameToLogInfoTitle($tableName)
{
    $nameArr = explode('_', $tableName);
    foreach ($nameArr as $key => $name) {
        $nameArr[$key] = Str::singular($name);
    }
    $name = implode(' ', $nameArr);
    return ucwords($name);
}


function changeLogTableColumnName($columnName)
{
    $nameArr = explode('_', $columnName);
    foreach ($nameArr as $key => $name) {
        $nameArr[$key] = Str::singular($name);
    }
    $name = implode(' ', $nameArr);
    return ucfirst($name);
}

function compareLogData($beforeData, $afterData)
{
    $newAfterData = json_decode($afterData);
    unset($newAfterData->updated_at);
    unset($newAfterData->updated_at);
    unset($newAfterData->id);
    unset($newAfterData->user_id);
    unset($newAfterData->created_at);
    unset($newAfterData->remember_token);
    unset($newAfterData->is_login_verified);

    $newBeforeData = json_decode($beforeData);

    $changedData = [];

    foreach ($newAfterData as $key => $data) {
        $obj = new \stdClass();
        $obj->field = changeLogTableColumnName($key);
        $obj->original = $newBeforeData->$key;
        $obj->changed = $data;
        array_push($changedData, $obj);
    }

    return ($changedData);
}

function formateDate($date, $format = null, $default = true)
{
    if (!empty($date) && $default) {
        return date('Y-m-d', strtotime($date));
    } else {
        return date($format, strtotime($date));
    }
    return null;
}

function formattedNpPrice($number, $npUnicode = false)
{
    $number = trim($number);
    $negative = '';
    $thousands = '';
    $formatted_paise = '';

    if (strstr($number, "-")) // For Negative Price
    {
        $number = str_replace("-", "", $number);
        $negative = "-";
    }

    $numbers = explode(".", $number);

    $rupee = isset($numbers[0]) ? $numbers[0] : 0;
    $paise = isset($numbers[1]) ? $numbers[1] : 0;

    if (strlen($rupee) > 3) {
        $hundreds = substr($rupee, strlen($rupee) - 3);
        $reverseNumber = strrev(substr($rupee, 0, strlen($rupee) - 3));
        $array = str_split($reverseNumber, 2);

        foreach ($array as $number) {
            $thousands .= $number . ",";
        }

        $thousands = strrev(trim($thousands, ","));

        $formatted_rupee = $thousands . "," . $hundreds;
    } else {
        $formatted_rupee = $rupee;
    }

    if ((int)$paise > 0) {
        $formatted_paise = "." . substr($paise, 0, 2);
    }

    $result = $negative . $formatted_rupee . $formatted_paise;

    if ($npUnicode) {
        $replace = array("१", "२", "३", "४", "५", "६", "७", "८", "९", "०");
        $find = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $nep_str    =  str_replace($find, $replace, $result);
        return 'रु. ' . $nep_str;
    } else {
        return 'Rs. ' . $result;
    }
}

function decryptData($value)
{
    try {
        $hash = new Hashids('', 6);
        return $hash->decode($value)[0];
    } catch (\Exception $ex) {
        return $value;
    }
}

function encryptData($value)
{
    try {
        $hash = new Hashids('', 6);
        return $hash->encode($value, 6);
    } catch (\Exception $ex) {
        return $value;
    }
}

function getToken($type)
{
    if ($type == "email")
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    else
        return rand(123456, 987654);
}

function generateRandomPassword()
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}


function formatDate($date, $format = 'd M Y', $fullDate = null)
{
    if ($date == '0000-00-00' || empty($date))
        return '-';

    if ($fullDate == 'true') {
        return date('l d F Y', strtotime($date));
    }

    return date($format, strtotime($date));
}


function getAttribute($attributes, $search)
{
    $index = null;
    if (count($attributes) > 0) {
        $index = array_search($search, array_column(json_decode(json_encode($attributes), true), 'type'));

        return  $index;
    }
    return null;
}

function getCreateExportPath()
{
    if (!is_dir(base_path() . '/public/uploads/exports/temp')) {
        mkdir(base_path() . '/public/uploads/exports/temp', 0777, true);
    }
    return true;
}

function getProjectBasePath($createFolder = false)
{
    if ($createFolder) {
        return base_path();
    }
    if (env('APP_ENV') == 'production') {
        return trim(config('nextsmart-settings.base_url'));
    }
    return base_path();
}

function getBadgeByStatus($actualStatus)
{
    switch ($actualStatus) {
        case '1':
            return '<span class="text-center badge badge-success rounded text-white">Active</span>';

        case '0':
            return '<span class="text-center badge badge-danger rounded text-white">Inactive</span>';

        default:
            return '<span class="text-center badge badge-danger rounded text-black">Inactive</span>';
    }
}

function getBadgeByFeature($actualStatus)
{
    switch ($actualStatus) {
        case '1':
            return '<span class="text-center badge badge-success rounded text-white">Yes</span>';

        case '0':
            return '<span class="text-center badge badge-danger rounded text-white">No</span>';

        default:
            return '<span class="text-center badge badge-danger rounded text-black">No</span>';
    }
}

function getSiteSetting()
{
    $siteSetting = SiteSetting::first();
    return !empty($siteSetting) ? $siteSetting : null;
}

function getStorageType()
{
    $setting = getSiteSetting();
    return $setting->storage_type ?? 'local';
}

function setStorageConfig()
{
    $setting = getSiteSetting();
    $storageType = getStorageType();

    if ($storageType == 'wasabi') {
        config('filesystems.disks.wasabi.driver', "s3");
        config('filesystems.disks.wasabi.key', $setting->storage_access_key);
        config('filesystems.disks.wasabi.secret', $setting->storage_secret_key);
        config('filesystems.disks.wasabi.region', $setting->storage_region);
        config('filesystems.disks.wasabi.bucket', $setting->storage_bucket_name);
        config('filesystems.disks.wasabi.endpoint', 'https://s3.' . $setting->storage_region . '.wasabisys.com');
    }
}

function setSMTP()
{
    if (config('app.env') != 'local') {
        $setting = getSiteSetting();
        config('mail.mailers.smtp.driver', $setting->mail_driver);
        config('mail.mailers.smtp.host', $setting->mail_host);
        config('mail.mailers.smtp.port', $setting->mail_port);
        config('mail.mailers.smtp.encryption', $setting->mail_encryption);
        config('mail.mailers.smtp.username', $setting->mail_user_name);
        config('mail.mailers.smtp.password', $setting->mail_password);
    }
}

function getFilePath($uploadPath, $fileName, $signed = false)
{
    $storageType =  getStorageType();
    $filePath = [];
    if (empty($fileName))
        return $filePath;
    if ($storageType && $storageType != 'local') {
        $realPath = $uploadPath . "/" . $fileName;
        $thumbPath = $uploadPath . "/thumb/" . $fileName;
        $realPath = buildUploadPathUrl($realPath);
        $thumbPath = buildUploadPathUrl($thumbPath);
        if (checkFileType($fileName) == 'image') {
            $filePath = [
                "original" => s3_image_url($realPath, $signed),
                "thumb" => s3_image_url($thumbPath, $signed),
            ];
        } else {
            $filePath = [
                "original" => s3_image_url($realPath, $signed),
            ];
        }
    } else {
        if (checkFileType($fileName) == 'image') {
            $filePath = [
                "original" => asset($uploadPath . "/" . $fileName),
                "thumb" => asset($uploadPath . "/thumb/" . $fileName),
            ];
        } else {
            $filePath = [
                "original" => asset($uploadPath . "/" . $fileName),
            ];
        }
    }
    return $filePath;
}

function buildUploadPathUrl($path)
{
    if (config('app.env') == "production") {
        return $path;
    } else {
        return "local/" . $path;
    }
}

function s3_image_url($path, $signed = false)
{
    if (config('app.env') == 'local') {
        $path = 'local/' . $path;
    } else {
        setStorageConfig();
        $storageType =  getStorageType();
        if ($storageType != 'local') {
            if ($signed) {
                $client = \Illuminate\Support\Facades\Storage::disk($storageType)->getClient();
                $command = $client->getCommand('GetObject', [
                    'Bucket' => getSiteSetting()->storage_bucket_name,
                    'Key' => $path
                ]);
                $request = $client->createPresignedRequest($command, '+10 minutes');

                return (string)$request->getUri();
            } else {
                return \Illuminate\Support\Facades\Storage::disk($storageType)->url($path);
            }
        }
    }
}

function checkFileType($imageName)
{
    $imageType = ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'ico'];

    $docType = ['docx', 'doc'];

    $spreadType = ['xls', 'xlsx'];

    $image = explode('.', $imageName);

    if (isset($image[1])) {
        if (in_array($image[1], $imageType))
            return "image";

        if (in_array($image[1], $docType)) {
            return "doc";
        }

        if ($image[1] == 'cvs' || $image[1] == 'txt') {
            return "cvs";
        }

        if (in_array($image[1], $spreadType)) {
            return "xls";
        }

        return 'pdf';
    }
}
