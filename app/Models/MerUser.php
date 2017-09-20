<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerUser extends Model
{
    public $table = 'mer_user';

    public function UserDevice(){
        return $this->hasOne('App\Models\MerUserDevice');
    }

}
