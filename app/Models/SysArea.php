<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysArea extends Model
{
    public $table = 'sys_area';

    public $primaryKey = 'id';

    public $timestamps = FALSE;

    use \App\Traits\Service\Scope;

    public function scopePid($query ,$param){
        if($param !== '')
            return $query->where('pid',$param);
    }
}
