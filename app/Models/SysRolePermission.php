<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysRolePermission extends Model
{
    public $table = 'sys_role_permission';

    public $primaryKey = 'id';

    public $timestamps = false ;

    use \App\Traits\Service\Scope;

    public function sysFuncs(){
        return  $this->belongsToMany('App\Models\SysFunc' , 'sys_func_privilege' , 'func_id' , 'id');
    }
}
