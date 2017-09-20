<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysRolePermission extends Model
{
    public $table = 'sys_role_permission';

    public $primaryKey = 'id';

    public $timestamps = false ;
}
