<?php

namespace App\Helpers;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class FileStorageHelper extends Storage
{
    public static function localReplace(string $filePath, string $storageFolder, string $storagePath = '')
    {
        if ($storagePath && self::disk('local')->exists($storagePath)) {
            self::disk('local')->delete($storagePath);
        }

        return self::disk('local')->putFile($storageFolder, new File($filePath));
    }
}
