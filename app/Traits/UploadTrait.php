<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    public function uploadFile(UploadedFile $uploadedFile, $folder = null, $fileName = null, $disk = 'local')
    {
        $name = $fileName ?? Str::random(25) . '.' . $uploadedFile->getClientOriginalExtension();
        // $options = []
        $file = Storage::putFileAs($folder, $uploadedFile, $name);
        return $file;
    }
}
