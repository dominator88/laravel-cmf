<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysUser extends Model
{
    public $table = 'sys_user';

    public $primaryKey = 'id';

    public $timestamps = FALSE;

    use \App\Traits\Service\Scope;


}
