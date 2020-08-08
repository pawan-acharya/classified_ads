<?php

namespace App\Traits;

use App\File;

trait WithFiles
{
    
    public static function bootWithFiles()
    {
        static::deleted(function ($model) {
            $model->files->each(function ($file) {
                $file->delete();
            });
        });
    }

    public function file()
    {
        return $this->morphOne(File::class, 'uploadable')->latest('id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'uploadable');
    }

}