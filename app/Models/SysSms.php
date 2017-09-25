<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysSms extends Model
{
    protected $table = 'sys_sms';

    public $primaryKey = 'id';

    public $timestamps = FALSE;

    use \App\Traits\Service\Scope;

    public function scopeKeyword($query  , $param){
        if($param !== '')
            return $query->where( 'name' , 'like' , "%{$param}%");
    }
}
