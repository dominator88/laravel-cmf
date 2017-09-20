<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerUserDevice extends Model
{
    public function User(){
        return $this->belongsTo('App\Models\MerUser');
    }
    //
}
