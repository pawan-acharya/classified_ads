<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['message', 'reply_by'];

    public function chat()
    {
        return $this->belongsTo('App\Chat');
    }
}
