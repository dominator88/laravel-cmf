<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysMail extends Model
{
    protected  $table = 'sys_mail';

    public $primaryKey = 'id';

    public $timestamps = false;

    use \App\Traits\Service\Scope;

    public function scopeKeyword($query , $param){
        if($param)
            return $query->where('keyword' , 'like' , "%{$param}%");
    }
    //
}
