<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerSysUser extends Model
{
    public $table = 'mer_sys_user';

    public $primaryKey  = 'id';

    public $timestamps = false;

    use \App\Traits\Service\Scope;
    //

    public function scopeKeyword($query ,$param){
        if($param)
            return $query->where('name' , 'like', "%{$param}%");
    }


}
