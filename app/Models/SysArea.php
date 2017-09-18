<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysArea extends Model
{
    public $table = 'sys_area';

    public $primaryKey = 'id';

    public $timestamps = FALSE;

    public function scopeModule($query , $param ){
        if($param !== 0)
            return $query->where('module',$param);

    }


    public function scopeStatus($query , $param){
        if($param !== '')
            return $query->where('module',$param);
    }

    public function scopeKeyword($query , $param){
        if($param)
            return $query->where('keyword' , 'like' , "%{$param}%");
    }

    public function scopeGetAll($query , $params){
        if(!$params['getAll']){
            return $query->skip(($params['page']-1) * $params['pageSize'] )->take($params['pageSize'] );
        }

    }

    public function scopePid($query ,$param){
        if($param !== '')
            return $query->where('pid',$param);
    }
}
