<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysFunc extends Model
{
    public $table = 'sys_func';

    public $primaryKey = 'id';

    public $timestamps = false ;

    use \App\Traits\Service\Scope;

    public function scopeIsMenu($query , $param){
        if($param)
            return $query->where('is_menu',$param);
    }



    public function sysRolePermissions(){
        return $this->belongsToMany('App\Models\SysRolePermission' , 'sys_func_privilege' , 'id' , 'func_id');
    }


}
