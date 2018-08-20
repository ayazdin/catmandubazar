<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postcat extends Model
{
    //
    public function cat_relation()
    {
        return $this->hasMany('App\Models\Cat_relation', 'catid');
    }
}
