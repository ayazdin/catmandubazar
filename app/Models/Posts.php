<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    //
    public function postmeta()
    {
        return $this->hasMany('App\Models\Postmeta', 'postid');
    }
}
