<?php

namespace App\Traits;

use Image;
use Schema;
use Storage;
use Str;
use App\File;

trait Uploader
{

    public static function upload($file)
    {
        $name = $file->getClientOriginalName();
        $mime = $file->getMimeType();
        $size = $file->getSize();

    
        $type = 'file';
        $class = File::class;
        $path = $file->store('public/'.Str::plural($type));
        
        // Storage::disk('local')->put($path, $file);
        $path = Storage::putFile(Str::plural($type), $file);
        return compact('name', 'mime', 'size', 'path');
    }
}