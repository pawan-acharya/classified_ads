<?php

namespace App;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    protected $fillable = ['name', 'mime', 'size', 'path', 'extra'];

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            Storage::delete($model->attributes['path']);
        });
    }

    public function uploadable()
    {
        return $this->morphTo();
    }

    public function getPathAttribute()
    {
        if (!array_key_exists('path', $this->attributes)) {
            return null;
        }

        return Storage::url($this->attributes['path']);
    }
}
